<?php declare(strict_types=1);

namespace Geo\Adapter\Symfony\GeoBundle\EventSubscriber\Elastica;

use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Geo\Domain\Model\City;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CityTimestampSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TransformEvent::POST_TRANSFORM => 'addTimestamp'
        ];
    }

    public function addTimestamp(TransformEvent $event)
    {
        /** @var Document $document */
        $document = $event->getDocument();
        $city = $event->getObject();

        if ($city instanceof City) {
            $document->set('timestamp', date(\DateTime::ATOM));
        }
    }
}
