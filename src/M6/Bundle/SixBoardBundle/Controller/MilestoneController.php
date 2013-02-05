<?php

namespace M6\Bundle\SixBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use M6\Bundle\SixBoardBundle\Controller\Controller;
use M6\Bundle\SixBoardBundle\Entity\Milestone;
use M6\Bundle\SixBoardBundle\Form\MilestoneType;

/**
 * Milestone controller.
 *
 * @Route("/admin/milestone")
 */
class MilestoneController extends Controller
{
    /**
     * Lists all Milestone entities.
     *
     * @Route("/", name="admin_milestone")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->getRepository('M6SixBoardBundle:Milestone')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Milestone entity.
     *
     * @Route("/", name="admin_milestone_create")
     * @Method("POST")
     * @Template("M6SixBoardBundle:Milestone:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Milestone;
        $form   = $this->createForm(new MilestoneType, $entity);

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_milestone_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Milestone entity.
     *
     * @Route("/new", name="admin_milestone_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Milestone;
        $form   = $this->createForm(new MilestoneType, $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Milestone entity.
     *
     * @Route("/{id}", name="admin_milestone_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('M6SixBoardBundle:Milestone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Milestone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Milestone entity.
     *
     * @Route("/{id}/edit", name="admin_milestone_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('M6SixBoardBundle:Milestone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Milestone entity.');
        }

        $editForm = $this->createForm(new MilestoneType, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Milestone entity.
     *
     * @Route("/{id}", name="admin_milestone_update")
     * @Method("PUT")
     * @Template("M6SixBoardBundle:Milestone:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $this->getRepository('M6SixBoardBundle:Milestone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Milestone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createForm(new MilestoneType, $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_milestone_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Milestone entity.
     *
     * @Route("/{id}", name="admin_milestone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('M6SixBoardBundle:Milestone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Milestone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_milestone'));
    }

    /**
     * Creates a form to delete a Milestone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
