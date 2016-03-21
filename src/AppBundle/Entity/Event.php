<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 * 
 */
abstract class Event
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="even_datetime", type="datetime")
     */
    private $evenDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime")
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime")
     */
    private $enddate;

    /**
     * @var bool
     *
     * @ORM\Column(name="alldayevent", type="boolean")
     */
    private $alldayevent;


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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set evenDatetime
     *
     * @param \DateTime $evenDatetime
     *
     * @return Event
     */
    public function setEvenDatetime($evenDatetime)
    {
        $this->evenDatetime = $evenDatetime;

        return $this;
    }

    /**
     * Get evenDatetime
     *
     * @return \DateTime
     */
    public function getEvenDatetime()
    {
        return $this->evenDatetime;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Event
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return Event
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set alldayevent
     *
     * @param boolean $alldayevent
     *
     * @return Event
     */
    public function setAlldayevent($alldayevent)
    {
        $this->alldayevent = $alldayevent;

        return $this;
    }

    /**
     * Get alldayevent
     *
     * @return bool
     */
    public function getAlldayevent()
    {
        return $this->alldayevent;
    }
}

