<?php declare(strict_types=1);

namespace Geo\Adapter\Port;

use Geo\Application\Exception\GeoValidationException;
use Geo\Application\Port\GeoValidatorInterface;
use Geo\Domain\Model\State;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GeoValidator implements GeoValidatorInterface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param State $state
     *
     * @throws GeoValidationException
     */
    public function validateState(State $state): void
    {
        $errors = $this->validator->validate($state);
        if (count($errors)) {
            throw new GeoValidationException($errors);
        }
    }
}
