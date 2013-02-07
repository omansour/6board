<?php

namespace M6\Bundle\SixBoardBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;

use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Note;

/**
 * Listener to handle state change on story
 */
class StateListener implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array('onFlush');
    }

    /**
     * When doctrine flush an entity
     *
     * @param LifecycleEventArgs $args args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();

        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $entity) {

            if ($entity instanceof Story) {

                if ($entity->getUser()) {

                    $changeSet = $uow->getEntityChangeSet($entity);

                    $note    = new Note($entity->getUser(), $entity);
                    $content = '';

                    foreach ($changeSet as $key => $data) {
                        if ($data[0] != $data[1]) {
                            switch ($key) {
                                case 'status':
                                    $oldStatus = Story::$statuses[$data[0]];
                                    $newStatus = Story::$statuses[$data[1]];

                                    $content .= $key. ' has changed from ' .  $oldStatus  . ' to ' . $newStatus . '<br />';
                                    break;

                                // other case to handle
                            }
                        }
                    }

                    $note->setNote($content);
                    $em->persist($note);

                    // ajoute a la liste des chose à sauvegarder car le persist ne suffit pas pour le onFlush()
                    $uow->computeChangeSet($em->getClassMetadata(get_class($note)), $note);
                }
            }
        }
    }
}
