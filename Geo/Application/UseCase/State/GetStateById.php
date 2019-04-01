<?php declare(strict_types=1);

namespace Geo\Application\UseCase\State;

use Geo\Application\Port\StateRepositoryInterface;
use Geo\Domain\Model\State;
use Geo\Domain\ValueObject\StateId;

class GetStateById
{
    /** @var StateRepositoryInterface */
    private $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * @param StateId $id
     *
     * @return State|null
     */
    public function execute(StateId $id): ?State
    {
        return $this->stateRepository->findStateById($id);
    }
}
