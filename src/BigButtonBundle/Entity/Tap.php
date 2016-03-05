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
     * @ORM\ManyToOne(targetEntity="BigButtonBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="BigButtonBundle\Entity\Task")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;
    
    /**
     * @var boolean
     * true = tâche en cours
     *
     * @ORM\Column(name="inProgress", type="boolean")
     */
    private $inProgress;

    /**
     * @var boolean
     * true = évènement ponctuel
     *
     * @ORM\Column(name="oneShot", type="boolean")
     */
    private $oneShot;

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->inProgress = false;
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
     * Set user
     *
     * @param \BigButtonBundle\Entity\User $user
     *
     * @return Tap
     */
    public function setUser(\BigButtonBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BigButtonBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Task
     *
     * @param \BigButtonBundle\Entity\Task $task
     *
     * @return Tap
     */
    public function setTask(\BigButtonBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get Task
     *
     * @return \BigButtonBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set inProgress
     *
     * @param boolean $state
     *
     * @return Tap
     */
    public function setInProgress($state)
    {
        $this->inProgress = $state;

        return $this;
    }

    /**
     * Get inProgress
     *
     * @return boolean
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     * Set oneShot
     *
     * @param boolean $oneShot
     *
     * @return Tap
     */
    public function setOneShot($oneShot)
    {
        $this->oneShot = $oneShot;

        return $this;
    }

    /**
     * Get oneShot
     *
     * @return boolean
     */
    public function getOneShot()
    {
        return $this->oneShot;
    }

    /**
     *  Formatte une durée en fonction de son ordre de grandeur
     *
     * @param Tap
     *
     * @return string
     */
    public function formatDuree(Tap $debut){

        $diff=$this->date->diff($debut->getDate());
        if($diff->d==0){
            if($diff->h==0){
                if($diff->i==0){
                    $duree="moins d'une minute";
                }else{
                    $duree=$diff->format("%i minutes %s secondes");
                }
            }else{
                $duree=$diff->format("%h heures %i minutes %s secondes");
            }
        }else{
            $duree=$diff->format("%a jours %h heures %i minutes %s secondes");
        }
        return $duree;
    }
}
