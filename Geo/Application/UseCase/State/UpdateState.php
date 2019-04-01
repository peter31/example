<?php declare(strict_types=1);

namespace Geo\Application\UseCase\State;

use Geo\Application\Command\State\UpdateStateCommand;
use Geo\Application\Exception\GeoValidationException;
use Geo\Application\Port\GeoValidatorInterface;
use Geo\Application\Port\StateRepositoryInterface;
use Geo\Domain\Model\State;

class UpdateState
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
     * @param State $state
     * @param UpdateStateCommand $command
     *
     * @throws GeoValidationException
     */
    public function execute(State $state, UpdateStateCommand $command): void
    {
        if (null !== $command->name) {
            $state->setName($command->name);
        }

        if (null !== $command->abbr) {
            $state->setAbbr($command->abbr);
        }

        $this->geoValidator->validateState($state);

        $this->stateRepository->updateState($state);
    }
}
