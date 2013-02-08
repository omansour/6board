<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use M6\Bundle\SixBoardBundle\Form\StoryPriorityType;
use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Milestone;

/**
 * Story controller
 */
class PriorityController extends Controller
{
    /**
     * Liste des stories par priorité
     */
    public function indexAction()
    {
        $filters = $this->getFilters('m6_search_priority');

        $form = $this->createForm(new SearchPriorityType, $filters);

        if ($request->query->has($form->getName())) {
            $form->bind($request);

            if ($form->isValid()) {
                $filters = $this->setFilters('m6_search_priority', $form->getData());
            }
        }

        $filters = $this->getFilters('m6_search_priority');

        $query = $this->getRepository("M6SixBoardBundle:Story")->search($filters);

        return array(
            'form'    => $form->createView(),
            'stories' => $query->getQuery()->execute(),
        );
    }


    /**
     * @Route("/story/priority", name="story_priority_index")
     * @Template()
     *
     * @param Request $request The Request
     *
     * @return array
     */
    public function priorityAction(Request $request)
    {
        $form = $this->createForm(new StoryPriorityType);

        if ($request->getMethod() == "POST") {
            $form->bind($request);

            if ($form->isValid()) {
                $data    = $form->getData();
                $results = $this->getRepository("M6SixBoardBundle:Story")->fecthStoryViaMilestone($data['milestone']);
            }

        }

        return array(
            'form'        => $form->createView(),
            'results'     => isset($results) ? $results : null,
            'milestoneId' => isset($data['milestone']) ? $data['milestone']->getId() : null,
        );
    }


    /**
     * @Route("/story/priority/move/{id}", name="reorder_story")
     * @Template()
     *
     * @param Request $request The Request
     *
     * @return JsonResponse
     */
    public function moveAction(Request $request, Milestone $milestone)
    {
        $storyId  = $request->query->get('storyId');
        $position = $request->query->get('position');

        $story = $this->getRepository("M6SixBoardBundle:Story")->find($storyId);

        $sm = $this->getRepository("M6SixBoardBundle:StoryMilestone")->findOneBy(array(
            'milestone' => $milestone,
            'story'     => $story
        ));

        $sm->setRank((int) $position);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($sm);
        $em->flush();

        return new JsonResponse();
    }


}

