<?php

namespace TestsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestsBundle:Default:index.html.twig');
    }
    public function transitionAction()
    {
        return $this->render('TestsBundle:Tests:transition.html.twig');
    }    
    public function structureAction()
    {
        return $this->render('TestsBundle:Tests:structure.html.twig');
    }
    // affiche tous les cookies enregistrés par le site
    public function cookiesAction()
    {
        return $this->render('TestsBundle:Tests:cookies.html.twig');
    }
    // affiche le header envoyé par le site
    public function headerAction()
    {
        $request = Request::createFromGlobals();

        // the URI being requested (e.g. /about) minus any query parameters
        $content=$request->getPathInfo();

        return $this->render('TestsBundle:Tests:header.html.twig',array('request'=>$request,'content'=>$content));
    }
}
