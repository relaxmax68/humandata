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
}

