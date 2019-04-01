<?php declare(strict_types=1);

namespace Geo\Adapter\Elasticsearch;

use Elastica\Query\BoolQuery;
use Elastica\Query\Wildcard;
use Elastica\SearchableInterface;
use Snapcart\ElasticsearchBundle\ElasticsearchRepository;

class ProvinceESRepository extends ElasticsearchRepository
{
    use FindAllRawTrait;
    use GetLastModifiedDateTrait;

    protected $rawSortMap = ['name'];

    /** @var SearchableInterface */
    protected $index;

    /**
     * @param SearchableInterface $provincesIndex
     *
     * @return ProvinceESRepository
     *
     * @required
     */
    public function setIndex(SearchableInterface $provincesIndex): self
    {
        $this->index = $provincesIndex;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function applyCriteria(BoolQuery $query, array $criteria = [], string $locale = null)
    {
        if (isset($criteria['name'])) {
            $array = explode(' ', $criteria['name']);
            foreach ($array as $word) {
                $nameMatch = new Wildcard('name', \sprintf("*%s*", \strtolower($word)));
                $query->addMust($nameMatch);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function isOrderByEnabled(array $criteria = [])
    {
        return !isset($criteria['match']);
    }
}
