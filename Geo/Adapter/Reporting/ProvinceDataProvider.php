<?php declare(strict_types=1);

namespace Geo\Adapter\Reporting;

use Snapcart\Reporting\Domain\ValueObject\DataIdentifier;

class ProvinceDataProvider extends AbstractDoctrineDataProvider
{
    protected function getQueryFields(): string
    {
        return
            'CAST_CHAR(p.id) AS id, ' .
            '(:country_code) as country, ' .
            'p.updatedAt as updated_at, ' .
            'p.isDeleted as deleted, ' .
            'p.name as name, ' .
            'p.slug as slug'
        ;
    }

    protected function getFrom(): string
    {
        return 'Geo\Domain\Model\Province p';
    }

    protected function getCountField(): string
    {
        return 'p.id';
    }

    protected function getWhere(): string
    {
        return '(p.updatedAt > :last_updated_at OR p.id > :last_id)';
    }

    protected function getOrderBy(): string
    {
        return 'p.updatedAt, p.id';
    }

    protected function getDataIdentifierFields(): array
    {
        return ['updated_at', 'id'];
    }

    protected function getQueryParameters(DataIdentifier $identifier): array
    {
        $identifier = $identifier->value();

        return [
            'country_code' => $this->country,
            'last_updated_at' => new \DateTime($identifier['updated_at'] ?? '2015-01-01 00:00:00'),
            'last_id' => (int)($identifier['id'] ?? 0),
        ];
    }
}
