<?php declare(strict_types=1);

namespace Geo\Adapter\Symfony\GeoBundle\EventSubscriber\Elastica;

use Elastica\Document;
use FOS\ElasticaBundle\Event\TransformEvent;
use Geo\Domain\Model\Province;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProvinceTimestampSubscriber implements EventSubscriberInterface
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
        $province = $event->getObject();

        if ($province instanceof Province) {
            $document->set('timestamp', date(\DateTime::ATOM));
        }
    }
}
