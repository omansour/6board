<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Story;
use M6\Bundle\SixBoardBundle\Entity\Search;
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

        $saveSearchForm = $this->createForm(new SavedSearchType, new Search());

        return array(
            'form'       => $form->createView(),
            'pagination' => $pager,
            'save_search_form' => $saveSearchForm->createView(),
            'unique_milestone' => (array_key_exists('milestone', $filters) && count($filters['milestone']) == 1) ? $filters['milestone'][0] : false,
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
     * @Method({"POST"})
     */
    public function saveFiltersAction(Request $request)
    {
        $filters = $this->getFilters('m6_search_board', array(), false);
        $search = new Search($this->getUser(), $filters);

        $form = $this->createForm(new SavedSearchType, $search);
        $form->bind($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($search);
            $this->getDoctrine()->getManager()->flush();
        }

        $this->addFlash('success', 'The search has been successfully saved');

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/filters/load/{id}", name="load_saved_filters")
     * @Template()
     */
    public function loadFiltersAction(Search $search)
    {
        if ($search->isPublic() || $this->getUser()->getId() == $search->getUser()->getId()) {
            $filters = $this->setFilters('m6_search_board', $search->getSearch(), false);
        } else {
            $this->addFlash('error', 'The search you\'re trying to access to is not public');
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/filters", name="browse_filters")
     * @Template("M6SixBoardBundle:Search:browse.html.twig")
     */
    public function browseFiltersAction()
    {
        $entities = $this->getRepository('M6SixBoardBundle:Search')->findByUser($this->getUser());

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/filters/edit/{id}", name="edit_filters")
     * @Template("M6SixBoardBundle:Search:edit.html.twig")
     */
    public function editFiltersAction(Request $request, Search $search)
    {
        if ($this->getUser()->isUser($search->getUser())) {

            $form = $this->createForm(new SavedSearchType, $search);

            if ($request->isMethod('POST')) {
                $form->bind($request);

                if ($form->isValid()) {
                    $this->getDoctrine()->getManager()->persist($search);
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash('success', 'The search has been saved');
                }
            }

            return array(
                'entity' => $search,
                'form' => $form->createView(),
            );

        } else {
            $this->addFlash('error', 'The search you\'re trying to access to is not public');

            return $this->redirect($this->generateUrl('homepage'));
        }
    }
}
