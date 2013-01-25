<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Doctrine\Common\Collections\ArrayCollection;

class Controller extends BaseController
{
   /**
     * Get repository
     *
     * @param string $class class
     *
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository($class)
    {
        return $this->getDoctrine()->getManager()->getRepository($class);
    }

    /**
     * Set flash
     *
     * @param string $type type
     * @param string $text text
     */
    protected function setFlash($type, $text)
    {
        $this->get('session')->getFlashBag()->add($type, $this->trans($text));
    }

    /**
     * Set filters
     *
     * @param array  $filters Filters
     * @param string $type    Type
     */
    public function setFilters($name, array $filters = array())
    {
        foreach ($filters as $key => $value) {
            // Transform entities objects into a pair of class/id
            if (is_object($value)) {
                if ($value instanceof ArrayCollection) {
                    if (count($value)) {
                        $filters[$key] = array(
                            'class' => get_class($value->first()),
                            'ids' => array()
                        );
                        foreach ($value as $v) {
                            $identifier = $this->getDoctrine()->getManager()->getUnitOfWork()->getEntityIdentifier($v);
                            $filters[$key]['ids'][] = $identifier['id'];
                        }
                    } else {
                        unset($filters[$key]);
                    }
                } elseif (!$value instanceof \DateTime) {
                    $filters[$key] = array(
                        'class' => get_class($value),
                        'id'    => $this->getDoctrine()->getManager()->getUnitOfWork()->getEntityIdentifier($value)
                    );
                }
            }
        }

        $this->getRequest()->getSession()->set(
            $name,
            $filters
        );
    }

    /**
     * Get Filters
     *
     * @param array $filters Filters
     * @param type  $type    Type
     *
     * @return array
     */
    public function getFilters($name, array $filters = array())
    {
        $filters = array_merge(
            $this->getRequest()->getSession()->get(
                $name,
                array()
            ),
            $filters
        );

        foreach ($filters as $key => $value) {
            // Get entities from pair of class/id
            if (is_array($value) && isset($value['class'])) {
                if (isset($value['id'])) {
                    $filters[$key] = $this->getDoctrine()->getManager()->find($value['class'], $value['id']);
                } elseif (isset($value['ids'])) {
                    $data = $this->getDoctrine()->getManager()->getRepository($value['class'])->findBy(array('id' => $value['ids']));
                    $filters[$key] = new ArrayCollection($data);
                }
            }
        }

        return $filters;
    }

    /**
     * Returns the pager
     *
     * @param integer        $page    Page
     * @param integer        $perPage Max per page
     * @param Doctrine_Query $query   Query
     *
     * @return \Pagination
     */
    public function getPager($page = 1, $perPage = 10, $query = null)
    {
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $page,
            $perPage
        );

        return $pagination;
    }

}
