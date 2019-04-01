<?php declare(strict_types=1);

namespace Geo\Application\UseCase\State;

use Geo\Domain\Model\State;
use Geo\Application\Command\State\CreateStateCommand;
use Geo\Application\Exception\GeoValidationException;
use Geo\Application\Port\StateRepositoryInterface;
use Geo\Application\Port\GeoValidatorInterface;
use Geo\Domain\ValueObject\StateId;

class CreateState
{
    /** @var StateRepositoryInterface */
    private $stateRepository;

    /** @var GeoValidatorInterface */
    private $geoValidator;

    public function __construct(
        StateRepositoryInterface $stateRepository,
        GeoValidatorInterface $geoValidator
    ) {
        $this->stateRepository = $stateRepository;
        $this->geoValidator = $geoValidator;
    }


    /**
     * @param CreateStateCommand $command
     *
     * @return StateId
     * @throws GeoValidationException
     */
    public function execute(CreateStateCommand $command): StateId
    {
        $state = new State();
        $state->setName($command->name);
        $state->setAbbr($command->abbr);

        $this->geoValidator->validateState($state);

        $this->stateRepository->updateState($state);

        return StateId::existing($state->getId());
    }
}
