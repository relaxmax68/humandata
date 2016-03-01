<?php

namespace BigButtonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="tap_user")
 * @ORM\Entity(repositoryClass="BigButtonBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAddress", type="string", length=255)
     */
    private $ipAddress;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="BigButtonBundle\Entity\Tap")
     * @ORM\JoinColumn(nullable=false)
     *
     * @ORM\Column(name="lasttap", type="object")
     */
    private $lastTap;

    public function __construct(){

        $this->setName("new user");
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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return User
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
     * Set lastTap
     *
     * @param \stdClass $lastTap
     *
     * @return User
     */
    public function setLastTap($lastTap)
    {
        $this->lastTap = $lastTap;

        return $this;
    }

    /**
     * Get lastTap
     *
     * @return \stdClass
     */
    public function getLastTap()
    {
        return $this->lastTap;
    }
}
