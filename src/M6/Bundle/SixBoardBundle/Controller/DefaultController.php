<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Form\SearchType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $filters = $this->getFilters('m6_search_board');

        // si rien filtre par defaut

        $form  = $this->createForm(new SearchType, $filters);

        $form->bind($request);

        if ($form->isValid()) {
            $filters = $this->setFilters('m6_search_board', $form->getData());
        }

        // $query      = $this->getRepository("M6SixBoardBundle:Story")->search($filters);
        // $maxResults = $this->container->getParameter('max_result_search');
        // $pager      = $this->getPager($request->query->get('page', 1), $maxResults, $query);

        return array(
            'form'    => $form->createView(),
            // 'results' => $pager,
        );
    }


}
