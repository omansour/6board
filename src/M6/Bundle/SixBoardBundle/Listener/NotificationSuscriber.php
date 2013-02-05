<?php

namespace M6\Bundle\SixBoardBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Doctrine\ORM\EntityManager;

use M6\Bundle\SixBoardBundle\Event\Events;
use M6\Bundle\SixBoardBundle\Mailer\Mailer;
use M6\Bundle\SixBoardBundle\Entity\Follow;

/**
 * Notification Ssuscriber class
 */
class NotificationSuscriber implements EventSubscriberInterface
{
    protected $em;
    protected $mailer;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager The em
     * @param Mailer        $mailer        The mailer
     */
    public function __construct(EntityManager $entityManager, Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->em     = $entityManager;
    }

    /**
     * Returns the suscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::STORY_NEW    => 'onNewStory',
            Events::STORY_UPDATE => 'onUpdateStory'
        );
    }

    /**
     * Tiggered by the creation of a new story
     *
     * @param GenericEvent $event The generic event
     */
    public function onNewStory(GenericEvent $event)
    {
        $story = $event->getSubject();

        $followers = $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($story, Follow::STORY);

        // gets the followers of the story's milestone too
        foreach ($story->getMilestones() as $milestone) {
            $followers[] = $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($milestone, Follow::MILESTONE);

            // gets the followers of project's milestone
            foreach ($milestone->getProject() as $project) {
                $followers[] = $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($project, Follow::PROJECT);
            }
        }

        $this->mailer->sendNewStory($story, $user);
    }

    /**
     * Tiggered by the creation of a new story
     *
     * @param GenericEvent $event The generic event
     */
    public function onUpdateStory(GenericEvent $event)
    {
        $story = $event->getSubject();
    }

}
