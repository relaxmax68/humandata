<?php
// src/AccueilBundle/IP/IPListener.php

namespace AccueilBundle\IP;

use AccueilBundle\Entity\Visite;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class IPListener
{
  protected $doctrine;

  public function __construct($doctrine)
  {
      $this->doctrine  = $doctrine;
  }

  // L'argument de la méthode est un FilterControllerEvent
  public function processIP(FilterControllerEvent $event)
  {
    // Ici on détermine l'adresse IP du visiteur
    if (!empty($_SERVER["HTTP_CLIENT_IP"])){
      //check for ip from share internet
      $ip = $_SERVER["HTTP_CLIENT_IP"];
    }elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
      // Check for the Proxy User
      $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else{
      $ip = $_SERVER["REMOTE_ADDR"];
    }

    $visite = new Visite();
    $visite->setIpAddress($ip);
    $visite->setDateFirstVisit(new \datetime());
    $visite->setDateLastVisit(new \datetime());

    $this->doctrine->persist($visite);
    $this->doctrine->flush();
    //$this->doctrine->getRepository('AccueilBundle:Visite');
  }
}