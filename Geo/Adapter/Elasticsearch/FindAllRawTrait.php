<?php declare(strict_types=1);

namespace Geo\Adapter\Elasticsearch;

use Elastica\Query;
use Elastica\Result;
use Elastica\Scroll;
use Elastica\SearchableInterface;

trait FindAllRawTrait
{
    /** @var SearchableInterface */
    protected $index;

    public function findAllRaw(): array
    {
        $query = new Query(new Query\Exists('id'));
        $query->setSort(['id' => 'asc'])->setSize(100);
        $search = $this->index->createSearch($query);

        $scroll = new Scroll($search);
        $result = [];

        foreach ($scroll as $page) {
            $pageResults = array_map(
                function (Result $elasticaResult) {
                    return $elasticaResult->getSource();
                },
                $page->getResults()
            );

            $result = array_merge($result, $pageResults);
        }

        return $result;
    }
}
