<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use M6\Bundle\SixBoardBundle\Controller\Controller;

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
            'form'       => $form->createView(),
            'stories' => $query->getQuery()->execute(),
        );
    }

    /**
     * On déplace une story par rapport a une autre
     */
    public function moveAction(Story $story)
    {
        // on doit recevoir l'id de la story précédente (ou null si premier)
    }

}
