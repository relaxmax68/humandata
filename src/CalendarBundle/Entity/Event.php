<?php
namespace CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CalendarBundle\Repository\EventRepository")
 * @ORM\Table(name="events")
 */
class Event {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=true, length=255)
     */
     private $title = '';
     /**
      * @var string
      *
      * @ORM\Column(name="description", type="text", nullable=true)
      */
     private $description = '';
     /**
      * @var \DateTime
      *
      * @ORM\Column(name="start", type="datetime")
      */
     private $start;
     /**
      * @var \DateTime
      *
      * @ORM\Column(name="end", type="datetime")
      */
     private $end;

     /**
      * @ORM\ManyToOne(targetEntity="BigButtonBundle\Entity\User",cascade={"persist"}))
      * @ORM\JoinColumn(nullable=false)
      */
     private $user;

     public function getId() {
         return $this->id;
     }

     public function getTitle() {
         return $this->title;
     }

     public function setTitle($title) {
         $this->title = $title;
         return $this;
     }

     public function getDescription() {
         return $this->description;
     }

     public function setDescription($description) {
         if (!is_null($description)) {
             $this->description = $description;
         }
         return $this;
     }

     public function getStart() {
         return $this->start;
     }

     public function setStart(\DateTime $start) {
         $this->start = $start;
         return $this;
     }

     public function getEnd() {
         return $this->end;
     }

     public function setEnd(\DateTime $end) {
         $this->end = $end;
         return $this;
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
