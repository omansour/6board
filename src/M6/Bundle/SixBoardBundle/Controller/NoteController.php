<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Note;
use M6\Bundle\SixBoardBundle\Form\NoteType;

/**
 * Note controller
 */
class NoteController extends Controller
{
    /**
     * @Route("/note/show/{id}", name="story_notes")
     * @Template("M6SixBoardBundle:Note:story_notes.html.twig")
     */
    public function storyNotesAction(Request $request, Story $story)
    {
        $note = new Note($this->getUser(), $story);
        $form = $this->createForm(new NoteType(), $note);

        return array(
            'story' => $story,
            'form'     => $form->createView(),
        );
    }

    /**
     * @Route("/note/create/{id}", name="note_create")
     * @Template()
     * @Method({"POST"})
     */
    public function createAction(Request $request, Story $story)
    {
        $note = new Note($this->getUser(), $story);
        $form = $this->createForm(new NoteType(), $note);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Your note has been added');
        }
        else
        {
            $this->addFlash('error', 'Your note has not been added because it contained errors');
        }

        return $this->redirect($this->generateUrl('show_story', array('id' => $story->getId())));

    }
}
