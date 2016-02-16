<?php
// src/UserBundle/Entity/User.php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 */
class User extends BaseUser
{
	/**
	* @ORM\Column(name="id", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

    /**
     * @return expiresAt
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
    /**
     * @return credentialsExpireAt
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }
}