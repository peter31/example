<?php declare(strict_types=1);

namespace Geo\Application\Exception;

use Throwable;

class GeoValidationException extends \Exception
{
    /** @var mixed */
    private $errors;

    public function __construct($errors, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
