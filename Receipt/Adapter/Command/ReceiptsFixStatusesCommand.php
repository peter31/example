<?php declare(strict_types=1);

namespace Receipt\Adapter\Command;

use AppBundle\Exception\ValidationHttpException;
use AppBundle\UseCase\Receipt\ReviewAndUpdateReceipt;
use Doctrine\ORM\EntityManagerInterface;
use Receipt\Adapter\Doctrine\ReceiptDbRepository;
use Receipt\Application\StatusFix\StatusFixStrategiesManager;
use Receipt\Domain\Model\Receipt;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReceiptsFixStatusesCommand extends Command
{
    /** @var StatusFixStrategiesManager */
    private $statusFixStrategiesManager;
    /** @var ReceiptDbRepository */
    private $receiptDbRepository;
    /** @var ReviewAndUpdateReceipt */
    private $reviewAndUpdateReceipt;
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        StatusFixStrategiesManager $statusFixStrategiesManager,
        ReceiptDbRepository $receiptDbRepository,
        ReviewAndUpdateReceipt $reviewAndUpdateReceipt,
        EntityManagerInterface $entityManager
    ) {
        $this->statusFixStrategiesManager = $statusFixStrategiesManager;
        $this->receiptDbRepository = $receiptDbRepository;
        $this->reviewAndUpdateReceipt = $reviewAndUpdateReceipt;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('snapcart:receipts:fix-statuses')
            ->addOption('batch-size', null, InputOption::VALUE_OPTIONAL, '', 100)
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, '')
            ->addOption('offset', null, InputOption::VALUE_OPTIONAL, '', 0)
            ->addOption('type', null, InputOption::VALUE_OPTIONAL, 'Allowed: active_chain_items, remoderation_chain_items, verified_chain, non_grocery_chain')
            ->setDescription('Fix receipts and receipt items statuses');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $batchSize = (int)$input->getOption('batch-size');
        $type = $input->getOption('type') ?? '';
        $limit = $input->getOption('limit');
        $additionalOffset = (int)$input->getOption('offset');

        $receiptIdsGetter = $this->statusFixStrategiesManager->getStrategyByName($type);

        $iterationCounter = $receiptsCounter = 0;
        do {
            $offset = ($batchSize * $iterationCounter++) + $additionalOffset;
            $receiptIdsResult = $receiptIdsGetter->getReceiptIds($batchSize, $offset);

            if (count($receiptIdsResult->getData())) {
                $receipts = $this->receiptDbRepository->findBy(['id' => $receiptIdsResult->getData()]);

                /** @var Receipt $receipt */
                foreach ($receipts as $receipt) {
                    $receiptsCounter++;

                    try {
                        $oldStatus = $receipt->getStatus();

                        $result = $this->reviewAndUpdateReceipt->execute($receipt);

                        if (null === $result) {
                            $output->writeln(
                                sprintf(
                                    '#%d, offset %d - ID %d. Status: %s -> %s - %s MB',
                                    $receiptsCounter,
                                    $offset,
                                    $receipt->getId(),
                                    $oldStatus,
                                    $receipt->getStatus(),
                                    round(memory_get_usage() / 1024 / 1024, 2)
                                )
                            );
                        } else {
                            $output->writeln(sprintf('#%d, offset %d, ID %d validation errors: %s', $receiptsCounter, $offset, $receipt->getId(), $result->has(0) ? $result->get(0)->getMessage() : ''));
                        }

                        unset($result);
                    } catch (ValidationHttpException | \Exception $ex) {
                        $output->writeln(sprintf('#%d, offset %d - ID %d exception: %s', $receiptsCounter, $offset, $receipt->getId(), $ex->getMessage()));
                    }

                    unset($receipt);
                }
            }

            unset($receipts);

            $this->entityManager->clear();
        } while (!$receiptIdsResult->getFinished() && (null === $limit || $batchSize * $iterationCounter < $limit));
    }
}
