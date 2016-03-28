<?php
namespace CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BladeTester\CalendarBundle\Entity\Event as BaseEvent;


/**
 * @ORM\Entity(repositoryClass="BladeTester\CalendarBundle\Repository\EventRepository")
 * @ORM\Table(name="events")
 */
class Event extends BaseEvent {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="BigButtonBundle\Entity\User",cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \BigButtonBundle\Entity\User $user
     *
     * @return Event
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
}
