<?php

namespace BigButtonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BigButtonBundle\Entity\Tap;
use BigButtonBundle\Entity\User;
use BigButtonBundle\Entity\Task;
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

        //on cherche une IP déjà enregistrée dans la BDD tap_user grâce au service IPListener
        $user=$this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

        //si première visite on l'enregistre et on l'affiche par défaut
        if(empty($user)){
            $user = new User();
            $user->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
            $lasttap = new Tap();
            $lasttask = new Task();
            $em->persist($user);
        }else{
            $lasttap=$user->getLastTap();
            if(empty($lasttap)){$lasttap=new Tap();}
            $lasttask=$lasttap->getTask();
        }

        //si c'est une activité qui vient d'être crée alors elle s'affiche par défaut



        $tap = new Tap();
        $tap->setUser($user);
        $tap->setTask($lasttask);
        $tap->setInProgress($lasttap->getInProgress());
        $em->persist($tap);

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(TapType::class,$tap);

        //traitement du formulaire
		$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {
            
            $tap->setDate(new \Datetime());
            $tap->setInProgress(!$tap->getInProgress());

            //On vérifie qu'une tâche équivalente n'a pas déjà été enregistrée
            if($this->getdoctrine()->getRepository('BigButtonBundle:Task')->findOneByName($tap->getTask()->getName())){
                $tap->setTask($this->getdoctrine()->getRepository('BigButtonBundle:Task')->findOneByName($tap->getTask()->getName()));
            }else{
                $task=new Task();
                $task->setName($tap->getTask()->getName());
                $tap->setTask($task);
                $em->persist($task);
            }
            //On vérifie qu'un utilisateur équivalent n'a pas déjà été enregistré
            if($this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByName($tap->getUser()->getName())){
                $tap->setUser($this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByName($tap->getUser()->getName()));
                $em->detach($user->getLastTap()->getTask());
            }else{
                $user=new User();
                $user->setName($tap->getUser()->getName());
                $user->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
                $tap->setUser($user);
                $em->persist($user);
                $em->flush();
            }
            $user->setLastTap($tap);
            $em->flush();

	    	$session->getFlashBag()->add('info', "Tap du ".$tap." enregistré !!!");
		}

        $lastdiff=date_diff(new \Datetime(),$lasttap->getDate());                                                    
        //Une activité est-elle déjà en cours ?
        if($tap->getInProgress()){
            $session->getFlashBag()->add('start', "ACTIVITÉ EN COURS");
            // depuis : ".$lastdiff->format("%a jours %h heures %i minutes %s secondes"));
        }else{
            $session->getFlashBag()->add('stop', "En PAUSE");
            // depuis : ".$lastdiff->format("%a jours %h heures %i minutes %s secondes"));
            $diff=$tap->formatDuree($lasttap->getDate());
            $session->getFlashBag()->add('duree', "La dernière activité ".$diff);
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

        $end  = new \Datetime();
        $start= (new \Datetime())->setTime(0,0,0);

        $user=$repositoryUser->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

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
                $tap = new Tap();
                $tap->setTask(new Task());
                $ajout->setLastTap($tap);
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

        $ajout->setName($cookie[1]);

        //enregistrement en BDD
        $em->persist($ajout);
        $em->flush();
        
        //on affiche la nouvelle valeur dans le formulaire
        //
        //
        //
        //

        //retour au formulaire
        return $this->redirectToRoute('big_button_homepage');
    }
}
