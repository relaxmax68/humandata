<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AccueilBundle:Default:index.html.twig',array('listProjets'=>array()));
    }

    public function menuAction($limit)
    {
        
        $listProjets = array(
          array('id' => 1, 'title' => 'gestion de rappels','comment' => 'Bienvenue dans le projet de création d\'un gestionnaire de rappels'),
          array('id' => 2, 'title' => 'club RH'),
          array('id' => 3, 'title' => 'mini réseau social'),
          array('id' => 4, 'title' => 'gestion de SEL'),
          array('id' => 5, 'title' => 'guide de produits responsables'),          
        );

        return $this->render('AccueilBundle:Default:menu.html.twig', array(
          'listProjets' => $listProjets
        ));
  }
    public function accueilAction()
    {
        return $this->render('AccueilBundle:Default:index.html.twig');
    }
    public function projetsAction($id)
    {
        return $this->render('AccueilBundle:Default:projets.html.twig',array( 'id' => $id ));

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
