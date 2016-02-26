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

			$tap->setVisite($this->container->get('accueil.ip.listener')->getVisite());
			$tap->getVisite()->setTask();
			$tap->setTask($tap->getVisite()->getTask());
			$em = $this->getDoctrine()->getManager();
			$em->persist($tap);
	   		$em->flush();

			$session = $request->getSession();

	    	$session->getFlashBag()->add('info', "Tap du ".$tap." enregistré !!!");

	    	if($tap->getTask()){
	    		$session->getFlashBag()->add('start', "ACTIVITÉ EN COURS");
	    	}else{
				// on cherche le dernier tap enregistré
				$start=$em->getRepository('BigButtonBundle:Tap')->findOneByid($tap->getId()-1);

				if($start){
					$diff=date_diff($tap->getDate(),$start->getDate());
				}else{
					$diff=date_diff($tap->getDate(),new \Datetime());
				}

				$session->getFlashBag()->add('duree', "La dernière activité a duré : ".$diff->format("%a jours %h heures %i minutes %s secondes"));
	    		$session->getFlashBag()->add('stop', "PAUSE");
	    	}

		}

	    return $this->render('BigButtonBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
    public function statsAction()
    {
    	$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BigButtonBundle:Tap');

        $end  = new \Datetime();
        $start= (new \Datetime())->setTime(0,0,0);

        $taps = $repository->myFindVisite($this->container->get('accueil.ip.listener')->getVisite(),$start, $end);

        $i=0;
        $activites=array();
        foreach ($taps as $element) {
        	if(!$element->getTask()){
        		$activites[$i]['nom']	= $element->getAnalyse()->getItem();
         		$activites[$i]['duree']	= date_diff($start,$element->getDate())->format("%a jours %h heures %i minutes %s secondes");
         	}else{
         		$start=$element->getDate();
         		$i=$i+1;
         	}
        }

        return $this->render('BigButtonBundle:Default:stats.html.twig',array('activites' => $activites));
    }
}
