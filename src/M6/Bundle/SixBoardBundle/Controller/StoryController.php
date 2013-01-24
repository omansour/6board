<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Form\SearchType;
use M6\Bundle\SixBoardBundle\Entity\Story;

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
     * @Route("/story/new", name="new_story")
     * @Template()
     */
    public function newAction(Request $request)
    {
    }



}
