<?php

namespace AccueilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite")
 * @ORM\Entity(repositoryClass="AccueilBundle\Repository\VisiteRepository")
 */
class Visite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFirstVisit", type="datetime")
     */
    private $dateFirstVisit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLastVisit", type="datetime")
     */
    private $dateLastVisit;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAddress", type="string", length=255)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="identitification", type="string", length=255, nullable=true)
     */
    private $identitification;

    /**
     * @var string
     *
     * @ORM\Column(name="agent", type="string", length=255)
     */
    private $agent;
    
    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     */
    private $language;

    public function __construct()
    {
      $this->dateFirstVisit  = new \Datetime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateFirstVisit
     *
     * @param \DateTime $dateFirstVisit
     *
     * @return Visite
     */
    public function setDateFirstVisit($dateFirstVisit)
    {
        $this->dateFirstVisit = $dateFirstVisit;

        return $this;
    }

    /**
     * Get dateFirstVisit
     *
     * @return \DateTime
     */
    public function getDateFirstVisit()
    {
        return $this->dateFirstVisit;
    }

    /**
     * Set dateLastVisit
     *
     * @param \DateTime $dateLastVisit
     *
     * @return Visite
     */
    public function setDateLastVisit($dateLastVisit)
    {
        $this->dateLastVisit = $dateLastVisit;

        return $this;
    }

    /**
     * Get dateLastVisit
     *
     * @return \DateTime
     */
    public function getDateLastVisit()
    {
        return $this->dateLastVisit;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Visite
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set identitification
     *
     * @param string $identitification
     *
     * @return Visite
     */
    public function setIdentitification($identitification)
    {
        $this->identitification = $identitification;

        return $this;
    }

    /**
     * Get identitification
     *
     * @return string
     */
    public function getIdentitification()
    {
        return $this->identitification;
    }

    /**
     * Set agent
     *
     * @param string $agent
     *
     * @return Visite
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Visite
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
