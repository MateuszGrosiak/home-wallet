<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ExpensePlan;
use AppBundle\Form\ExpensePlanType;

/**
 * ExpensePlan controller.
 *
 * @Route("/expenseplan")
 */
class ExpensePlanController extends Controller
{
    /**
     * Lists all ExpensePlan entities.
     *
     * @Route("/", name="expenseplan_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $expensePlans = $em->getRepository('AppBundle:ExpensePlan')->findAll();

        return $this->render('expenseplan/index.html.twig', array(
            'expensePlans' => $expensePlans,
        ));
    }

    /**
     * Creates a new ExpensePlan entity.
     *
     * @Route("/new", name="expenseplan_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $expensePlan = new ExpensePlan();
        $form = $this->createForm('AppBundle\Form\ExpensePlanType', $expensePlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expensePlan);
            $em->flush();

            return $this->redirectToRoute('expenseplan_show', array('id' => $expensePlan->getId()));
        }

        return $this->render('expenseplan/new.html.twig', array(
            'expensePlan' => $expensePlan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ExpensePlan entity.
     *
     * @Route("/{id}", name="expenseplan_show")
     * @Method("GET")
     */
    public function showAction(ExpensePlan $expensePlan)
    {
        $deleteForm = $this->createDeleteForm($expensePlan);

        return $this->render('expenseplan/show.html.twig', array(
            'expensePlan' => $expensePlan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ExpensePlan entity.
     *
     * @Route("/{id}/edit", name="expenseplan_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ExpensePlan $expensePlan)
    {
        $deleteForm = $this->createDeleteForm($expensePlan);
        $editForm = $this->createForm('AppBundle\Form\ExpensePlanType', $expensePlan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expensePlan);
            $em->flush();

            return $this->redirectToRoute('expenseplan_edit', array('id' => $expensePlan->getId()));
        }

        return $this->render('expenseplan/edit.html.twig', array(
            'expensePlan' => $expensePlan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ExpensePlan entity.
     *
     * @Route("/{id}", name="expenseplan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ExpensePlan $expensePlan)
    {
        $form = $this->createDeleteForm($expensePlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expensePlan);
            $em->flush();
        }

        return $this->redirectToRoute('expenseplan_index');
    }

    /**
     * Creates a form to delete a ExpensePlan entity.
     *
     * @param ExpensePlan $expensePlan The ExpensePlan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ExpensePlan $expensePlan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expenseplan_delete', array('id' => $expensePlan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
