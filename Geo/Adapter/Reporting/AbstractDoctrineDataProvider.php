<?php

declare(strict_types=1);

namespace Geo\Adapter\Reporting;

use Geo\Domain\ValueObject\HashedField;
use Doctrine\ORM\EntityManagerInterface;
use Snapcart\Reporting\Domain\DataProviderInterface;
use Snapcart\Reporting\Domain\ValueObject\DataIdentifier;
use Snapcart\Reporting\Domain\ValueObject\ReportData;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AbstractDoctrineDataProvider
 * @package Geo\Adapter\Reporting
 */
abstract class AbstractDoctrineDataProvider implements DataProviderInterface
{
    /**
     * @var string
     */
    protected $country;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $hashingFields = [];

    /**
     * AbstractDoctrineDataProvider constructor.
     * @param EntityManagerInterface $em
     * @param Serializer $reportingSymfonySerializer
     * @param string $reportingCountry
     */
    public function __construct(
        EntityManagerInterface $em,
        Serializer $reportingSymfonySerializer,
        string $reportingCountry
    ) {
        $this->em = $em;
        $this->serializer = $reportingSymfonySerializer;
        $this->setCountry($reportingCountry);
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * {@inheritdoc}
     * @throws \Snapcart\Reporting\Domain\ValueObject\Exception\InvalidTypeException
     * @throws \Snapcart\Reporting\Domain\ValueObject\Exception\NotSupportedDataKeyException
     */
    public function execute(DataIdentifier $identifier, int $limit = null): ReportData
    {
        $results = $this->query(
            'SELECT ' .
            $this->getQueryFields() . ' ' .
            'FROM ' . $this->getFrom() . ' ' .
            $this->getJoins() . ' ' .
            'WHERE ' . $this->getWhere() . ' ' .
            'ORDER BY ' . $this->getOrderBy(),
            $this->getQueryParameters($identifier),
            $limit
        );

        return new ReportData($results, $this->getDataIdentifierFields());
    }

    /**
     * @param DataIdentifier $identifier
     * @return int
     */
    public function count(DataIdentifier $identifier): int
    {
        $countQueryParams = $this->getCountQueryParameters($identifier);

        $results = $this->query(
            'SELECT ' .
            'COUNT(' . $this->getCountField() . ') AS cnt ' .
            'FROM ' . $this->getFrom() . ' ' .
            $this->getJoins() . ' ' .
            'WHERE ' . $this->getWhere(),
            $countQueryParams
        );

        return (int)$results[0]['cnt'];
    }

    /**
     * @param string $query
     * @param array $parameters
     * @param int|null $limit
     * @return array
     */
    protected function query(string $query, array $parameters, int $limit = null): array
    {
        $query = $this->em->createQuery($query);

        foreach ($parameters as $name => $value) {
            $query->setParameter($name, $value);
        }

        if (null !== $limit) {
            $query->setMaxResults($limit);
        }

        return $this->postProcessData($query->getResult());
    }

    /**
     * @param array $results
     * @return array
     */
    private function postProcessData(array $results): array
    {
        $processedResults = [];
        foreach ($results as $key => $result) {
            foreach ($result as $field => $value) {
                $value = $this->getSerializer()->normalize($value);
                if (\is_string($value)) {
                    $array = @\json_decode($value, true);
                    if ($array !== null && \json_last_error() === JSON_ERROR_NONE && \is_array($array)) {
                        $value = $array;
                    }
                }
                $value = $this->processHashing($field, $value);
                $result[$field] = $value;
            }

            $processedResults[] = $result;
        }

        return $processedResults;
    }

    /**
     * @param int|string $field
     * @param int|string|array $value
     * @return array|string
     */
    private function processHashing($field, $value)
    {
        $hashingFields = $this->hashingFields;

        if (\is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->processHashing($key, $item);
            }
            return $value;
        } elseif (\is_scalar($value) && \array_key_exists($field, $hashingFields)) {
            return (string)(new HashedField($hashingFields[$field], $value));
        } else {
            return $value;
        }
    }

    /**
     * @return Serializer
     */
    protected function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    /**
     * @return string
     */
    protected function getJoins(): string
    {
        return '';
    }

    /**
     * @param DataIdentifier $identifier
     * @return array
     */
    protected function getCountQueryParameters(DataIdentifier $identifier): array
    {
        $params = $this->getQueryParameters($identifier);

        if (isset($params['country_code'])) {
            unset($params['country_code']);
        }

        return $params;
    }

    /**
     * @return string
     */
    abstract protected function getQueryFields(): string;

    /**
     * @return string
     */
    abstract protected function getFrom(): string;

    /**
     * @return string
     */
    abstract protected function getCountField(): string;

    /**
     * @return string
     */
    abstract protected function getWhere(): string;

    /**
     * @return string
     */
    abstract protected function getOrderBy(): string;

    /**
     * @return array
     */
    abstract protected function getDataIdentifierFields(): array;

    /**
     * @param DataIdentifier $identifier
     * @return array
     */
    abstract protected function getQueryParameters(DataIdentifier $identifier): array;

    /**
     * @return array
     */
    public function getHashedFields(): array
    {
        return $this->hashingFields;
    }
}
