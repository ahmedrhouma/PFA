<?php

namespace App\Entity;

use App\Repository\EncryptedVoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EncryptedVoteRepository::class)
 */
class EncryptedVote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vote;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity=Elector::class, inversedBy="encryptedVotes")
     */
    private $elector;

    public function __construct()
    {
        $this->elector = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection|Elector[]
     */
    public function getElector(): Collection
    {
        return $this->elector;
    }

    public function addElector(Elector $elector): self
    {
        if (!$this->elector->contains($elector)) {
            $this->elector[] = $elector;
        }

        return $this;
    }

    public function removeElector(Elector $elector): self
    {
        if ($this->elector->contains($elector)) {
            $this->elector->removeElement($elector);
        }

        return $this;
    }
}
