<?php

namespace App\Site\Page\Domain\Event;

use App\Shared\Service\FileRemove;
use App\Site\Page\Domain\Entity\Slide;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postRemove)]
class SlideDelete
{
    public function __construct(private readonly FileRemove $fileRemove)
    {
    }

    public function postRemove(PostRemoveEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        if ($entity instanceof Slide) {
            $this->fileRemove->remove($entity->getName());
        }
    }
}
