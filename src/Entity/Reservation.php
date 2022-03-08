<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FLYING_FROM;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FLYING_TO;

    /**
     * @ORM\Column(type="date")
     */
    private $DEPARTING;

    /**
     * @ORM\Column(type="date")
     */
    private $Retour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adults;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $children;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $travel_class;

    /**
     * @ORM\ManyToMany(targetEntity=Voyage::class, inversedBy="reservations")
     */
    private $voyage;

    public function __construct()
    {
        $this->voyage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFLYINGFROM(): ?string
    {
        return $this->FLYING_FROM;
    }

    public function setFLYINGFROM(string $FLYING_FROM): self
    {
        $this->FLYING_FROM = $FLYING_FROM;

        return $this;
    }

    public function getFLYINGTO(): ?string
    {
        return $this->FLYING_TO;
    }

    public function setFLYINGTO(string $FLYING_TO): self
    {
        $this->FLYING_TO = $FLYING_TO;

        return $this;
    }

    public function getDEPARTING(): ?\DateTimeInterface
    {
        return $this->DEPARTING;
    }

    public function setDEPARTING(\DateTimeInterface $DEPARTING): self
    {
        $this->DEPARTING = $DEPARTING;

        return $this;
    }

    public function getRetour(): ?\DateTimeInterface
    {
        return $this->Retour;
    }

    public function setRetour(\DateTimeInterface $Retour): self
    {
        $this->Retour = $Retour;

        return $this;
    }

    public function getAdults(): ?string
    {
        return $this->adults;
    }

    public function setAdults(string $adults): self
    {
        $this->adults = $adults;

        return $this;
    }

    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function setChildren(string $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getTravelClass(): ?string
    {
        return $this->travel_class;
    }

    public function setTravelClass(string $travel_class): self
    {
        $this->travel_class = $travel_class;

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyage(): Collection
    {
        return $this->voyage;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyage->contains($voyage)) {
            $this->voyage[] = $voyage;
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        $this->voyage->removeElement($voyage);

        return $this;
    }
}
