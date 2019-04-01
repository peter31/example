<?php declare(strict_types=1);

namespace Geo\Application\Port;

use Geo\Application\Exception\GeoValidationException;
use Geo\Domain\Model\State;

interface GeoValidatorInterface
{
    /**
     * @param State $state
     * @throws GeoValidationException
     */
    public function validateState(State $state): void;
}
