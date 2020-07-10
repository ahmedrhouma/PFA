<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Elector::class, mappedBy="User", cascade={"persist", "remove"})
     */
    private $elector;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getElector(): ?Elector
    {
        return $this->elector;
    }

    public function setElector(?Elector $elector): self
    {
        $this->elector = $elector;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $elector ? null : $this;
        if ($elector->getUser() !== $newUser) {
            $elector->setUser($newUser);
        }

        return $this;
    }
}