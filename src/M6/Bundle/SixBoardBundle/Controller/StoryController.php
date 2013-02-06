<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Follow;
use M6\Bundle\SixBoardBundle\Entity\Note;
use M6\Bundle\SixBoardBundle\Event\Events;
use M6\Bundle\SixBoardBundle\Form\StoryType;

/**
 * Story controller
 */
class StoryController extends Controller
{
    /**
     * @Route("/story/show/{id}", name="show_story")
     * @Template()
     */
    public function showAction(Request $request, Story $story)
    {
        return array(
            'story' => $story
        );

    }

    /**
     * Displays a form to create a new Story entity.
     *
     * @Route("/story/new", name="story_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $story = new Story;
        $story->setOwnerUser($this->getUser());

        $form = $this->createForm(new StoryType, $story);

        if ($request->getMethod() == "POST") {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($story);
                $em->flush();

                // After persisting the new story :
                $this->get('event_dispatcher')->dispatch(Events::STORY_NEW, new GenericEvent($story));
                $this->get('event_dispatcher')->dispatch(Events::SUBSCRIBE, new GenericEvent($story, array('user' => $this->getUser(), 'type' => Follow::STORY)));
            }
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Story entity.
     *
     * @Route("/story/edit/{id}", name="story_edit")
     * @Template()
     */
    public function editAction(Request $request, Story $story)
    {
        $form = $this->createForm(new StoryType, $story);

        if ($request->getMethod() == "POST") {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($story);
                $em->flush();

                // After persisting the new story :
                $this->get('event_dispatcher')->dispatch(Events::STORY_EDIT, new GenericEvent($story));
                $this->get('event_dispatcher')->dispatch(Events::SUBSCRIBE, new GenericEvent($story, array('user' => $this->getUser(), 'type' => Follow::STORY)));

                $savedStory = $this->getRepository("M6SixBoardBundle:Story")->findOneById($story->getId());

                $repository = $this->getRepository('Gedmo\Loggable\Entity\LogEntry');
                $versions   = $repository->getLogEntries($story);

                $version = array_shift(array_values($versions))

                $repository->revert($story, $version->getVersion());

                $note = new Note($this->getUser(), $savedStory);

                $content = '';

                foreach ($version->getData() as $key => $data) {
                    switch ($key) {
                        case 'status':
                            $newStatus = $savedStory->{'get'.ucfirst($key)}();
                            $newStatus = Story::$statuses[$newStatus];

                            $oldStatus = $story->{'get'.ucfirst($key)}();
                            $oldStatus = Story::$statuses[$oldStatus];

                            $content .= $key. ' has changed from ' .  $oldStatus  . ' to ' . $newStatus . '<br />';
                            break;

                        default:
                            $content .= $key. ' has changed from ' .  $story->{'get'.ucfirst($key)}()  . ' to ' . $savedStory->{'get'.ucfirst($key)}() . '<br />';
                            break;
                    }
                }

                $story = $savedStory;
                $note->setNote($content);

                $em->persist($note);
                $em->flush($note);
            }
        }

        return array(
            'form'   => $form->createView(),
            'story'  => $story
        );
    }

    /**
     * @Route("/notes/show/{id}", name="notes_show")
     * @Template()
     *
     * @param Story $story The story
     *
     * @return array
     */
    public function noteAction(Story $story)
    {
        return array(
            'notes' => $story->getNotes()
        );
    }

}
