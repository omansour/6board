<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Form\SearchType;
use M6\Bundle\SixBoardBundle\Form\SavedSearchType;

/**
 * Search controller
 */
class SearchController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $filters = $this->getFilters('m6_search_board');

        $emptyFilters = true;

        foreach ($filters as $filter) {
             if (!empty($filter)) {
                $emptyFilters = false;
             }
        }

        if (true === $emptyFilters) {
            $filters = array('devUser' => new ArrayCollection(array($this->getUser())));
            $this->setFilters('m6_search_board', $filters);
            $filters = $this->getFilters('m6_search_board');
        }

        $form = $this->createForm(new SearchType, $filters);

        // We need to check if the name of the form is present in the url
        // form bind even if the user didn't clicked on searched
        // This is due because of the use of GET method instead of POST
        if ($request->query->has($form->getName())) {
            $form->bind($request);

            if ($form->isValid()) {
                $filters = $this->setFilters('m6_search_board', $form->getData());
            }
        }

        $filters = $this->getFilters('m6_search_board');

        $query      = $this->getRepository("M6SixBoardBundle:Story")->search($filters);
        $maxResults = $this->container->getParameter('max_result_search');
        $pager      = $this->getPager($request->query->get('page', 1), $maxResults, $query);

        return array(
            'form'       => $form->createView(),
            'pagination' => $pager,
        );
    }

    /**
     * @Route("/filters/reset", name="reset_filters")
     * @Template()
     */
    public function resetAction(Request $request)
    {
        $filters = $this->setFilters('m6_search_board', array());

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/filters/save", name="save_filters")
     * @Template()
     */
    public function saveFilters(Request $request)
    {
        $form = $this->createForm(new SavedSearchType, $filters);

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {

                $data = $form->getData();

                $search = new Search;
                $search->setSearch(serialize($this->getFilters('m6_search_board')));
                $search->setPublic($data['public']);
                $search->setName($data['name']);
                $search->setUser($this->getUser());

                $this->getDoctrine()->getEntityManager()->persist($search);
                $this->getDoctrine()->getEntityManager()->flush();

                $this->addFlash('success', sprintf('The search named %s has been successfully saved', $data['name']));
            }
        }

        return array(
            'form' => $form
        );
    }

    /**
     * @Route("/filters/load/{id}", name="load_saved_filter")
     * @Template()
     */
    public function loadFilters(Search $search)
    {
        if ($search->isPublic() || $this->getUser()->getId() == $search->getUser()->getId()) {
            $filters = $this->setFilters('m6_search_board', unserialize($search->getSearch()));
        } else {
            $this->addFlash('error', 'The search you\'re trying to access to is not public');
        }

        return $this->redirect($this->generateUrl('homepage'));
    }
}
