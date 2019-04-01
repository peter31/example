<?php

declare(strict_types=1);

namespace Geo\Domain\ValueObject;

/**
 * Class HashedField
 * @package Geo\Domain\ValueObject
 */
class HashedField
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $pattern;

    /**
     * HashedField constructor.
     * @param string $pattern
     * @param $value
     */
    public function __construct(string $pattern, $value)
    {
        if (!is_scalar($value)) {
            throw new \InvalidArgumentException(sprintf('The value must be of scalar type. %s provided', gettype($value)));
        }

        $this->pattern = $pattern;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return (string)preg_replace($this->pattern, '*', $this->value);
    }
}
