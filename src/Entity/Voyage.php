<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoyageRepository::class)
 */
class Voyage

{

    public function __toString()
    {
        return $this->nom_voyage;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $nom_voyage;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     */
    private $Ville_depart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 26,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $ville_destination;

    /**
     * @ORM\Column(type="date")
     *
     *
     */
    private $date_depart;

    /**
     * @ORM\Column(type="date")
     */
    private $date_retour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero_voyage;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 26,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     *
     */
    private $nom_agence;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_voyage;

    /**
     * @ORM\OneToOne(targetEntity=Promotion::class, mappedBy="voyage", cascade={"persist", "remove"})
     */
    private $promotion;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, mappedBy="voyage")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVoyage(): ?string
    {
        return $this->nom_voyage;
    }

    public function setNomVoyage(string $nom_voyage): self
    {
        $this->nom_voyage = $nom_voyage;

        return $this;
    }

    public function getVilleDepart(): ?string
    {
        return $this->Ville_depart;
    }

    public function setVilleDepart(string $Ville_depart): self
    {
        $this->Ville_depart = $Ville_depart;

        return $this;
    }

    public function getVilleDestination(): ?string
    {
        return $this->ville_destination;
    }

    public function setVilleDestination(string $ville_destination): self
    {
        $this->ville_destination = $ville_destination;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTimeInterface $date_retour): self
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getNumeroVoyage(): ?string
    {
        return $this->numero_voyage;
    }

    public function setNumeroVoyage(string $numero_voyage): self
    {
        $this->numero_voyage = $numero_voyage;

        return $this;
    }

    public function getNomAgence(): ?string
    {
        return $this->nom_agence;
    }

    public function setNomAgence(string $nom_agence): self
    {
        $this->nom_agence = $nom_agence;

        return $this;
    }

    public function getPrixVoyage(): ?float
    {
        return $this->prix_voyage;
    }

    public function setPrixVoyage(float $prix_voyage): self
    {
        $this->prix_voyage = $prix_voyage;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(Promotion $promotion): self
    {
        // set the owning side of the relation if necessary
        if ($promotion->getVoyage() !== $this) {
            $promotion->setVoyage($this);
        }

        $this->promotion = $promotion;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addVoyage($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeVoyage($this);
        }

        return $this;
    }
}
