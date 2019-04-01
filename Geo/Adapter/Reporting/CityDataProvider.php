<?php declare(strict_types=1);

namespace Geo\Adapter\Reporting;

use Snapcart\Reporting\Domain\ValueObject\DataIdentifier;

class CityDataProvider extends AbstractDoctrineDataProvider
{
    protected function getQueryFields(): string
    {
        return
            'CAST_CHAR(c.id) AS id, ' .
            "(:country_code) as country, " .
            'c.updatedAt as updated_at, ' .
            'c.isDeleted as deleted, ' .
            'c.name as name, ' .
            'c.slug as slug, ' .
            'IDENTITY(c.province) AS province_id'
        ;
    }

    protected function getFrom(): string
    {
        return 'Geo\Domain\Model\City c';
    }

    protected function getCountField(): string
    {
        return 'c.id';
    }

    protected function getWhere(): string
    {
        return '(c.updatedAt > :last_updated_at OR (c.updatedAt = :last_updated_at AND c.id > :last_id))';
    }

    protected function getOrderBy(): string
    {
        return 'c.updatedAt, c.id';
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
