<?php declare(strict_types=1);

namespace Geo\Adapter\Elasticsearch;

use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use Elastica\Query\Wildcard;
use Elastica\SearchableInterface;
use Snapcart\ElasticsearchBundle\ElasticsearchRepository;

class CityESRepository extends ElasticsearchRepository
{
    use FindAllRawTrait;
    use GetLastModifiedDateTrait;

    protected $rawSortMap = ['name'];
    /** @var SearchableInterface */
    protected $index;

    /**
     * @param SearchableInterface $citiesIndex
     *
     * @return CityESRepository
     *
     * @required
     */
    public function setIndex(SearchableInterface $citiesIndex): self
    {
        $this->index = $citiesIndex;

        return $this;
    }

    public function applyCriteria(BoolQuery $query, array $criteria = [], string $locale = null)
    {
        if (isset($criteria['name'])) {
            $array = explode(' ', $criteria['name']);
            foreach ($array as $word) {
                $nameMatch = new Wildcard('name', \sprintf("*%s*", \strtolower($word)));
                $query->addMust($nameMatch);
            }
        }

        if (isset($criteria['province'])) {
            $provinceTerm = new Terms();
            $provinceTerm->setTerms('province.id', [$criteria['province']]);
            $query->addMust($provinceTerm);
        }
    }

    public function isOrderByEnabled(array $criteria = [])
    {
        return !isset($criteria['name']);
    }
}
