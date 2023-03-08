<?php
namespace App\EventListener;

use App\Entity\HistoryRecord;
use App\Entity\Tournois;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class HistoryRecordListener implements EventSubscriber
{
public function getSubscribedEvents()
{
return [
Events::preRemove,
];
}

public function preRemove(LifecycleEventArgs $args)
{
$entity = $args->getObject();
$entityManager = $args->getEntityManager();

// Only create history records for entities that are instances of your custom entity classes
if (!$entity instanceof Tournois) {
return;
}

$historyRecord = new HistoryRecord();
$historyRecord->setEntityName(Tournois::class);
$historyRecord->setDeletedEntityId($entity->getId());
$historyRecord->setDeletedAt(new \DateTime());

$entityManager->persist($historyRecord);
$entityManager->flush();
}
}