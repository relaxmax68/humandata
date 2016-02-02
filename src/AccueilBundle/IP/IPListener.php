<?php
// src/AccueilBundle/IP/IPListener.php

namespace AccueilBundle\IP;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class IPListener
{
  // récupération de l'adresse IP
  protected $ip;
  // Date de connexion
  protected $date;

  public function __construct()
  {
      $this->date  = new \Datetime();
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

    $event->getRequest()->getSession()->getFlashBag()->add('info', "L'adresse IP est ".$ip);
  }
}