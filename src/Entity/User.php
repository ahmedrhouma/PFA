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
     * @ORM\OneToOne(targetEntity=Elector::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Elector;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getElector(): ?Elector
    {
        return $this->Elector;
    }

    public function setElector(Elector $Elector): self
    {
        $this->Elector = $Elector;

        return $this;
    }

}