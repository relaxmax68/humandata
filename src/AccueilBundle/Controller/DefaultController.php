<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AccueilBundle:Default:accueil.html.twig',array('listProjets'=>array()));
    }

    public function accueilAction()
    {
        return $this->render('AccueilBundle:Default:accueil.html.twig');
    }

    public function projetsAction($id)
    {
        return $this->render('AccueilBundle:Default:projets.html.twig',array( 'id' => $id ));
    }

    public function messageAction(Request $request, $id)
    {
        $session = $request->getSession();

        $session->getFlashBag()->add('info', "La page du projet ".$id." n'est pas encore disponible");
        return $this->redirectToRoute('accueil_homepage');
    }
}
