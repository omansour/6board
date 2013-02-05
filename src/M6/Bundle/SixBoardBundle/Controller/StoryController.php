<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\GenericEvent;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
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
}
