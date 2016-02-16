<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AccueilBundle:Default:accueil.html.twig');
    }

    public function projetsAction($id)
    {
        return $this->render('AccueilBundle:Default:projets.html.twig',array( 'id' => $id ));
    }

    public function administrationAction($id)
    {
        return $this->render('AccueilBundle:Default:administration.html.twig',array( 'id' => $id ));
    }

    public function messageAction(Request $request, $id)
    {
        $session = $request->getSession();

        $session->getFlashBag()->add('info', "La page ".$id." n'est pas encore disponible");
        return $this->redirectToRoute('accueil_homepage');
    }
}
