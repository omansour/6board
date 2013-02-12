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
    public function showAction(Story $story)
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
        $story = new Story($this->getUser());
        $story->setOwnerUser($this->getUser());

        $form = $this->createForm(new StoryType, $story);

        if ($request->getMethod() == "POST") {
            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($story);
                $em->flush();

                $this->get('event_dispatcher')->dispatch(Events::SUBSCRIBE, new GenericEvent($story, array('user' => $this->getUser(), 'type' => Follow::STORY)));
                $this->get('event_dispatcher')->dispatch(Events::STORY_NEW, new GenericEvent($story));

                $this->addFlash('success', 'The story has been added');

                return $this->redirect($this->generateUrl("show_story", array('id' => $story->getId())));
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
        // We need this line to know the current user whe
        // accessing to the entity on the StateListener as we have no access
        // to the security_context
        $story->setUser($this->getUser());

        $form = $this->createForm(new StoryType, $story);

        $prevCollections = $story->getStoryMilestones();
        $prevCollections = $prevCollections->toArray();

        if ($request->getMethod() == "POST") {
            $form->bind($request);

            foreach($prevCollections as $sm) {
                $story->removeStoryMilestone($sm);
            }

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($story);
                $em->flush();

                $this->get('event_dispatcher')->dispatch(Events::SUBSCRIBE, new GenericEvent($story, array('user' => $this->getUser(), 'type' => Follow::STORY)));
                $this->get('event_dispatcher')->dispatch(Events::STORY_EDIT, new GenericEvent($story));

                $this->addFlash('success', 'The story has been edited');

                return $this->redirect($this->generateUrl('show_story', array('id' => $story->getId())));
            }
        }

        return array(
            'form'   => $form->createView(),
            'story'  => $story
        );
    }
}
