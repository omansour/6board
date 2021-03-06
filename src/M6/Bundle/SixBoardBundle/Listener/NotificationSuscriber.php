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
        $this->em     = $entityManager;
        $this->mailer = $mailer;
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
            Events::NOTE_NEW     => 'onNewNote',
            Events::STORY_UPDATE => 'onUpdateStory',
            Events::SUBSCRIBE    => 'onSuscribe',
        );
    }

    /**
     * Tiggered by the creation of a new story
     *
     * @param GenericEvent $event The generic event
     */
    public function onSuscribe(GenericEvent $event)
    {
        $object = $event->getSubject();
        $user   = $event->getArgument('user');
        $type   = $event->getArgument('type');

        $result = $this->em->getRepository("M6SixBoardBundle:Follow")->findOneBy(array(
            'user'        => $user,
            'objectId'    => $object->getId(),
            'objectClass' => $type,
        ));

        if (!$result) {
            $follower = new Follow;
            $follower->setUser($user);
            $follower->setObjectId($object->getId());
            $follower->setObjectClass($type);

            $this->em->persist($follower);
            $this->em->flush();
        }
    }

    /**
     * Tiggered by the creation of a story
     *
     * @param GenericEvent $event The generic event
     */
    public function onNewStory(GenericEvent $event)
    {
        $story = $event->getSubject();

        // get followers for the story
        $followers = $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($story, Follow::STORY);

        // gets the followers of the story's milestone too
        foreach ($story->getStoryMilestones() as $storyMilestone) {
            $milestone = $storyMilestone->getMilestone();
            $followers += $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($milestone, Follow::MILESTONE);

            // gets the followers of project's milestone
            $project   = $milestone->getProject();
            $followers += $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($project, Follow::PROJECT);
        }

        // We ensure we only send one mail to each person
        $followers = array_unique($followers);

        $this->mailer->sendNewStory($story, $followers);
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

    /**
     * Tiggered by the creation of a note
     *
     * @param GenericEvent $event The generic event
     */
    public function onNewNote(GenericEvent $event)
    {
        $note = $event->getSubject();

        // get followers for the story
        $followers = $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($note, Follow::STORY);

        // gets the followers of the story's milestone too
        foreach ($note->getStoryMilestones() as $storyMilestone) {
            $milestone = $storyMilestone->getMilestone();
            $followers += $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($milestone, Follow::MILESTONE);

            // gets the followers of project's milestone
            $project   = $milestone->getProject();
            $followers += $this->em->getRepository("M6SixBoardBundle:Follow")->getFollowersFor($project, Follow::PROJECT);
        }

        // We ensure we only send one mail to each person
        $followers = array_unique($followers);

        $this->mailer->sendNewNote($note, $followers);
    }

}
