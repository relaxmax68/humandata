<?php

namespace CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

//use BigButtonBundle\Repository\UserRepository;


class DefaultController extends Controller
{
    public function indexAction()
    {
        if(!empty($this->getUser())){
            //on récupère l'utilisateur connecté
            $authentificatedUser=$this->getUser();
            //on récupère l'utilisateur par son IP
            $ipUser=$this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

            if($authentificatedUser->getUsername()==$ipUser->getName()){
    	    	    $events=$this->getdoctrine()->getRepository('CalendarBundle:Event')->findEventsByUser( $ipUser );

    		        return $this->render('CalendarBundle:Default:index.html.twig',array('events'=>$events));
            }else{
                throw new AccessDeniedException('Absence de données');
            }
        }else{
            throw new AccessDeniedException('Accès réservé');
        }
    }
}
