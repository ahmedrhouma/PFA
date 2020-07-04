<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Elector::class, mappedBy="event")
     */
    private $electors;

    /**
     * @ORM\OneToMany(targetEntity=Candidats::class, mappedBy="event")
     */
    private $candidats;

    /**
     * @ORM\OneToOne(targetEntity=EventResult::class, mappedBy="event", cascade={"persist", "remove"})
     */
    private $eventResult;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;



    public function __construct()
    {
        $this->electors = new ArrayCollection();
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Elector[]
     */
    public function getElectors(): Collection
    {
        return $this->electors;
    }

    public function addElector(Elector $elector): self
    {
        if (!$this->electors->contains($elector)) {
            $this->electors[] = $elector;
            $elector->addEvent($this);
        }

        return $this;
    }

    public function removeElector(Elector $elector): self
    {
        if ($this->electors->contains($elector)) {
            $this->electors->removeElement($elector);
            $elector->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Candidats[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidats $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setEvent($this);
        }

        return $this;
    }

    public function removeCandidat(Candidats $candidat): self
    {
        if ($this->candidats->contains($candidat)) {
            $this->candidats->removeElement($candidat);
            // set the owning side to null (unless already changed)
            if ($candidat->getEvent() === $this) {
                $candidat->setEvent(null);
            }
        }

        return $this;
    }

    public function getEventResult(): ?EventResult
    {
        return $this->eventResult;
    }

    public function setEventResult(EventResult $eventResult): self
    {
        $this->eventResult = $eventResult;

        // set the owning side of the relation if necessary
        if ($eventResult->getEvent() !== $this) {
            $eventResult->setEvent($this);
        }

        return $this;
    }
    function __toString()
    {
        return $this->title;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
