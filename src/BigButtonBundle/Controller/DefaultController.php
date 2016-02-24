<?php

namespace BigButtonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BigButtonBundle\Entity\Tap;
use AccueilBundle\Entity\Visite;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
		$tap = new Tap();

    	// On crée le FormBuilder grâce au service form factory
    	$form = $this->createFormBuilder($tap)
		->add('analyse', EntityType::class,	array('class'=> 'AccueilBundle:Analyse',
                      		                                'choice_label' => 'item',
                                                            'query_builder'=> function (EntityRepository $er) {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}))
        ->add('infos',  TextareaType::class,array('required' => false))
        ->add('tap',   SubmitType::class,  array('label'=>"TAP !"))
		->getForm();

		$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$visite = $this->container->get('accueil.ip.listener')->getVisite(); 
			$tap->setVisite($visite);

			$em = $this->getDoctrine()->getManager();
			$em->persist($tap);
	   		$em->flush();

			$session = $request->getSession();
	    	$session->getFlashBag()->add('info', "Tap du ".$tap." enregistré !!!");

		}

	    return $this->render('BigButtonBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
}
