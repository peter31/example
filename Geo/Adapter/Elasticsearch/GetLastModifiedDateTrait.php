<?php declare(strict_types=1);

namespace Geo\Adapter\Elasticsearch;

use Elastica\Aggregation\Max;
use Elastica\Query;
use Elastica\Result;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

trait GetLastModifiedDateTrait
{
    /** @var PaginatedFinderInterface */
    protected $finder;

    public function getLastModifiedDate(): ?\DateTime
    {
        $aggregation = new Max('max_timestamp');
        $aggregation->setField('timestamp');

        $query = new Query(new Query\Exists('timestamp'));
        $query->addAggregation($aggregation);

        /** @var Result $result */
        $aggregations = $this->finder->createHybridPaginatorAdapter($query)->getAggregations();
        $value = $aggregations['max_timestamp']['value'];

        if ($value) {
            $result = new \DateTime();
            //comes as milliseconds
            $result->setTimestamp((int) $value / 1000);

            return $result;
        }

        return null;
    }
}
