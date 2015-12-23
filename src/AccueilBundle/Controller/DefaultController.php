<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AccueilBundle:Default:index.html.twig');
    }
    public function accueilAction()
    {
        return $this->render('AccueilBundle:Default:index.html.twig');
    }
    public function gestionDeRappelsAction()
    {
        return $this->render('AccueilBundle:Default:gestionDeRappels.html.twig');
    }
    public function clubRHAction()
    {
        return $this->render('AccueilBundle:Default:clubRH.html.twig');
    }
    public function miniSocialAction()
    {
        return $this->render('AccueilBundle:Default:miniSocial.html.twig');
    }
    public function SELAction()
    {
        return $this->render('AccueilBundle:Default:SEL.html.twig');
    }
    public function guideResponsableAction()
    {
        return $this->render('AccueilBundle:Default:guideResponsable.html.twig');
    }
}
