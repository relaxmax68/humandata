<?php

namespace BigButtonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use BigButtonBundle\Entity\Tap;
use BigButtonBundle\Entity\User;
use BigButtonBundle\Entity\Task;
use CalendarBundle\Entity\Event;

use BigButtonBundle\Form\TapType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $tap = new Tap();

        //on cherche une IP déjà enregistrée dans la BDD tap_user grâce au service IPListener
        $user=$this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

        //si première visite on l'enregistre et on l'affiche par défaut
        if(empty($user)){
            $user = new User();
            $user->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
        }else{
            $lasttap=$this->getdoctrine()->getRepository('BigButtonBundle:Tap')->findOneById($this->getdoctrine()->getRepository('BigButtonBundle:Tap')->LastUserIdTap($user));
        }
        //si jamais aucune activité n'a été réalisée par l'utilisateur on en crée une vide
        if(empty($lasttap)){
            $lasttap  = new Tap();
            $lasttap->setTask( new Task());
        }else{
            $tap->setTask($lasttap->getTask());
        }

        $tap->setUser($user);
        $tap->setInProgress($lasttap->getInProgress());

        $em->persist($tap);
        $em->persist($user);

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(TapType::class,$tap);

        //traitement du formulaire
	    	$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tap->setDate(new \Datetime());
            $tap->setInProgress(!$tap->getInProgress());

            //On vérifie qu'une tâche n'a pas déjà été commencée
            if($lasttap->getInProgress() && $lasttap->getTask()!=$tap->getTask()){
                //on sauvegarde la nouvelle tâche saisie
                $newtask=$tap->getTask();
                //on termine l'ancienne tâche et on enregistre ce Tap!
                $tap->setInProgress(0);
                $tap->setTask($lasttap->getTask());
                $em->flush();
                //on active la nouvelle tâche
                $tap = new Tap();
                $tap->setUser($user);
                $tap->setTask($newtask);
                $tap->setInProgress(1);
                $em->persist($tap);
            }

            $em->flush();

	    	    $session->getFlashBag()->add('info', "Tap du ".$tap." enregistré !!!");
	    	}
        //affichage des avertissements d'état
        $lastdiff=date_diff(new \Datetime(),$lasttap->getDate());
        //Une activité est-elle déjà en cours ?
        if($tap->getInProgress()){
            $session->getFlashBag()->add('start', "ACTIVITÉ EN COURS");
        }else{
            $session->getFlashBag()->add('stop', "En PAUSE");
            $diff=$tap->formatDuree($lasttap->getDate());
            $session->getFlashBag()->add('duree', "La dernière activité ".$diff);
            //on sauvegarde le paramètre Top
            $em->flush();
        }

	      return $this->render('BigButtonBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
    public function statsAction()
    {
    	$repositoryTap = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BigButtonBundle:Tap');

        $repositoryUser = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BigButtonBundle:User');

        $em = $this
                ->getDoctrine()
                ->getManager();

        $end  = new \Datetime();
        $start= (new \Datetime())->setTime(0,0,0);

        $user=$repositoryUser->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

        //sauvegarde des Tap sous forme d'Event
        $taps = $repositoryTap->notSaved($user);

        foreach ($taps as $element) {
          if(!$element->getSaved()){
            if($element->getInProgress()){
              $event = new Event();
              $event->setTitle($element->getTask()->getName());
              $event->setDescription($element->getInfos());
              //$event->setCategory($element->getTask());
              $event->setStart($element->getDate());
              $event->setEnd($end);

              $event->setUser($element->getUser());

              $em->persist($event);
            }else{
              $event->setEnd($element->getDate());
            }
          }
          //on n'oublie pas de déclarer le tap «saved»
          $element->setSaved(true);
        }
        $em->flush();

        //préparation pour l'affichage synthétique
        $taps = $repositoryTap->myFindUserOnDuration($user,$start, $end);

        $i=0;
        $activites=array();
        foreach ($taps as $element) {
        	if(!$element->getInProgress()){
        		  $activites[$i]['nom']	  = $element->getTask()->getName();
         		  $activites[$i]['duree']	  = $element->formatDuree($start);
              $activites[$i]['i']       = $i;
              $activites[$i]['top']     = $element->getTop();
         	}else{
         		$start=$element->getDate();
         		$i=$i+1;
         	}
        }

        return $this->render('BigButtonBundle:Default:stats.html.twig',array('activites' => $activites));
    }
    public function addAction(Request $request){

        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $cookie = explode(':',$request->cookies->get('ajout'));

        if($cookie[0]=="user"){

            $repositoryUser = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('BigButtonBundle:User');
            //on vérifie qu'un enregistrement identique n'existe pas déjà
            $ajout=$repositoryUser->findOneByName($cookie[1]);
            if(empty($ajout)){
                $ajout = new User();
                $ajout->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
            }else{
                $session->getFlashBag()->add('erreur', "L'utilisateur « ".$cookie[1]." » est déjà enregistré !!!");
            }
        }
        if($cookie[0]=="task"){

            $repositoryTask = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('BigButtonBundle:Task');
            //on vérifie qu'un enregistrement identique n'existe pas déjà
            $ajout=$repositoryTask->findOneByName($cookie[1]);
            if(empty($ajout)){
                $ajout = new Task();
            }else{
                $session->getFlashBag()->add('erreur', "La tâche « ".$cookie[1]." » est déjà enregistrée !!!");
            }
        }

        //au cas où les cookies seraient désactivés
        if(!empty($ajout)){
            $ajout->setName($cookie[1]);
            //enregistrement en BDD
            $em->persist($ajout);
            $em->flush();
        }

        //retour au formulaire
        return $this->redirectToRoute('big_button_homepage');
    }
}
