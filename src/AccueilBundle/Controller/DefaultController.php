<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AccueilBundle:Default:pageDeGarde.html.twig');
    }
    public function accueilAction()
    {
        //flag qui lance une animation à la première présentation du formulaire
        if(empty($_SESSION['webFade'])){
          $_SESSION['webFade']=0;
        }
        $_SESSION['webFade']++;

        return $this->render('AccueilBundle:Default:index.html.twig', array('fade' => $_SESSION['webFade']));
    }

    public function projetsAction($id)
    {
        return $this->render('AccueilBundle:Accueil:projets.html.twig',array( 'id' => $id ));
    }

    public function administrationAction($id)
    {
        return $this->render('AccueilBundle:Accueil:administration.html.twig',array( 'id' => $id ));
    }

    public function messageAction(Request $request, $id = "")
    {
        $session = $request->getSession();

        $session->getFlashBag()->add('info', "La page ".$id." n'est pas encore disponible");
        return $this->redirectToRoute('accueil_homepage');
    }

    public function visitesAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AccueilBundle:Visite');

        $visites = $repository->findAll();
        return $this->render('AccueilBundle:Default:visites.html.twig',array('visites' => $visites));
    }
}
