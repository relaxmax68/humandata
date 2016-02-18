<?php

namespace TestsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
