<?php declare(strict_types=1);

namespace Receipt\Application\StatusFix;

class ReceiptIdsResult
{
    /** @var array */
    private $data;
    /** @var bool */
    private $finished;

    public function __construct(array $data, bool $finished)
    {
        $this->data = $data;
        $this->finished = $finished;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFinished(): bool
    {
        return $this->finished;
    }
}
