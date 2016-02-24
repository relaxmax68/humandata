<?php

namespace BigButtonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tap
 *
 * @ORM\Table(name="tap")
 * @ORM\Entity(repositoryClass="BigButtonBundle\Repository\TapRepository")
 */
class Tap
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
     * @ORM\ManyToOne(targetEntity="AccueilBundle\Entity\Visite", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $visite;

    /**
     * @ORM\ManyToOne(targetEntity="AccueilBundle\Entity\Object")
     * @ORM\JoinColumn(nullable=true)
     */
    private $object;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function __toString()
    {
        return $this->date->format("d:m:Y H:i:s");
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tap
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set infos
     *
     * @param string $infos
     *
     * @return Tap
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Set visite
     *
     * @param \AccueilBundle\Entity\Visite $visite
     *
     * @return Tap
     */
    public function setVisite(\AccueilBundle\Entity\Visite $visite)
    {
        $this->visite = $visite;

        return $this;
    }

    /**
     * Get visite
     *
     * @return \AccueilBundle\Entity\Visite
     */
    public function getVisite()
    {
        return $this->visite;
    }

    /**
     * Set object
     *
     * @param \AccueilBundle\Entity\Object $object
     *
     * @return Tap
     */
    public function setObject(\AccueilBundle\Entity\Object $object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \AccueilBundle\Entity\Object
     */
    public function getObject()
    {
        return $this->object;
    }
}
