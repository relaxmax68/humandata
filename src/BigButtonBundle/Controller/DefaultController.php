<?php

namespace BigButtonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BigButtonBundle\Entity\Tap;
use BigButtonBundle\Entity\User;
use BigButtonBundle\Entity\Task;
use BigButtonBundle\Form\TaskType;
use BigButtonBundle\Form\UserType;

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

        //si première visite on l'enregistre
        if(empty($user)){
            $user = new User();
            $user->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
            $lasttap = new Tap();
            $lasttask = new Task();
        }else{
            $lasttap=$user->getLastTap();
            if(empty($lasttap)){$lasttap=new Tap();}
            $lasttask=$lasttap->getTask();
        }
        $tap = new Tap();
        $tap->setInProgress($lasttap->getInProgress());

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createFormBuilder($tap)
        ->add('user', EntityType::class,array('class'=> 'BigButtonBundle:User',
                                                            'placeholder' => 'Choose an option',
                                                            'query_builder'=> function (EntityRepository $er)
                                                            {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}))
        ->add('task', EntityType::class,array('class'=> 'BigButtonBundle:Task',
                                                            'placeholder' => 'Choose an option',
                                                            'query_builder'=> function (EntityRepository $er)
                                                            {return $er->createQueryBuilder('u')->orderBy('u.id', 'ASC');}))
        ->add('infos',   TextareaType::class,array('required' => false))
        ->add('tap',     SubmitType::class,  array('label'    => "TAP !"))
        ->getForm();

        //$formBuilder = $this->get('form.factory')->createBuilder('form', $user);
        //$formBuilder = $this->get('form.factory')->createBuilder('form', $task);

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
            }else{
                $user=new User();
                $user->setName($tap->getUser()->getName());
                $user->setIpAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());
                $tap->setUser($user);
                $em->persist($user);
                $em->flush();
            }

            $em->persist($tap);
	   		$em->flush();
            $user->setLastTap($tap);
            $em->persist($user);
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
        	if($element->getInProgress()){
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
}
