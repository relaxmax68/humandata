<?php
// src/AccueilBundle/IP/IPDoctrine.php

namespace AccueilBundle\IP;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class IPDoctrine extends Controller implements ContainerAwareInterface 
{
  use ContainerAwareTrait;
  // Méthode pour ajouter le « bêta » à une réponse
  public function saveIP($visite,$ip)
  {
    // access services from the container!
    $em = $ip->getDoctrine()->getManager();
  }
}