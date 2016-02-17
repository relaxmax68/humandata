<?php

namespace AccueilBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AccueilBundle\Entity\Analyse;
use AccueilBundle\Form\AnalyseType;
use AccueilBundle\Entity\Object;
use AccueilBundle\Entity\Category;
/**
 * Analyse controller.
 *
 * @Route("/administration/analyse")
 */
class AnalyseController extends Controller
{
    /**
     * Lists all Analyse entities.
     *
     * @Route("/", name="administration_analyse_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $analyses = $em->getRepository('AccueilBundle:Analyse')->findAll();
        return $this->render('AccueilBundle:Analyse:index.html.twig', array(
            'analyses' => $analyses,
        ));
    }

    /**
     * Creates a new Analyse entity.
     *
     * @Route("/new", name="administration_analyse_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $analyse = new Analyse();
        $form = $this->createForm('AccueilBundle\Form\AnalyseType', $analyse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //var_dump($analyse);
            //die();
            $em->persist($analyse);
            $em->flush();

            return $this->redirectToRoute('administration_analyse_show', array('id' => $analyse->getId()));
        }

        return $this->render('AccueilBundle:Analyse:new.html.twig', array(
            'analyse' => $analyse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Analyse entity.
     *
     * @Route("/{id}", name="administration_analyse_show")
     * @Method("GET")
     */
    public function showAction(Analyse $analyse)
    {
        $deleteForm = $this->createDeleteForm($analyse);

        return $this->render('AccueilBundle:Analyse:show.html.twig', array(
            'analyse' => $analyse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Analyse entity.
     *
     * @Route("/{id}/edit", name="administration_analyse_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Analyse $analyse)
    {
        $deleteForm = $this->createDeleteForm($analyse);
        $editForm = $this->createForm('AccueilBundle\Form\AnalyseType', $analyse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analyse);
            $em->flush();

            return $this->redirectToRoute('administration_analyse_edit', array('id' => $analyse->getId()));
        }

        return $this->render('AccueilBundle:Analyse:edit.html.twig', array(
            'analyse' => $analyse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Analyse entity.
     *
     * @Route("/{id}", name="administration_analyse_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Analyse $analyse)
    {
        $form = $this->createDeleteForm($analyse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($analyse);
            $em->flush();
        }

        return $this->redirectToRoute('administration_analyse_index');
    }

    /**
     * Creates a form to delete a Analyse entity.
     *
     * @param Analyse $analyse The Analyse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Analyse $analyse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administration_analyse_delete', array('id' => $analyse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
