<?php
// src/AccueilBundle/IP/IPListener.php

namespace AccueilBundle\IP;

use AccueilBundle\Entity\Visite;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class IPListener
{
  protected $doctrine;
  protected $visite;

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
    //on cherche une IP déjà enregistrée dans la BDD
    $this->visite=$this->doctrine->getRepository('AccueilBundle:Visite')->findOneByipAddress($ip);
    //si première visite on l'enregistre
    if(empty($this->visite)){
      $this->visite = new Visite();
      $this->visite->setIpAddress($ip);
      $this->visite->setDateLastVisit(new \datetime());
      $this->visite->setAgent($_SERVER["HTTP_USER_AGENT"]);
      $this->visite->setLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    }
    //Dans tous les cas on enregistre la date de dernière visite et on incrémente le compteur de visites
    $this->visite->setDateLastVisit(new \datetime());
    $this->visite->incVisit();

    //on teste si le visiteur s'est authentifié pour identifier sa visite
    //ne marche pas
    if(!empty($user)){
      $this->visite->setIdentification($user->getUsername());
    }

    $this->doctrine->persist($this->visite);
    $this->doctrine->flush();

  }
  /**
  * get Visite
  *
  * @return Visite
  */
  public function getVisite()
  {
    return $this->visite;
  }
}