<?php

namespace BigButtonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BigButtonBundle\Entity\Tap;
use AccueilBundle\Entity\Visite;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BigButtonBundle:Default:index.html.twig');
    }
    public function tapAction(Request $request)
    {
		$session = $request->getSession();

		$tap = new Tap();
		$tap->setInfos("test");

		$visite = $this->container->get('accueil.ip.listener')->getVisite(); 
		$tap->setVisite($visite);

		$em = $this->getDoctrine()->getManager();
		$em->persist($tap);
   		$em->flush();


    	$session->getFlashBag()->add('info', $tap->afficheDate()." ENREGISTRÉE !!!");
        return $this->render('BigButtonBundle:Default:index.html.twig');
    }
}
