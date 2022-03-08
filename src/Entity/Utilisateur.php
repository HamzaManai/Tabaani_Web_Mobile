<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
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
    private $nom_utl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_utl;

    /**
     * @ORM\OneToMany(targetEntity=Hebergement::class, mappedBy="user")
     */
    private $hebergements;

    /**
     * @ORM\OneToMany(targetEntity=ReservationHebergement::class, mappedBy="utilisateur")
     */
    private $reservationHebergements;

    public function __construct()
    {
        $this->hebergements = new ArrayCollection();
        $this->reservationHebergements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtl(): ?string
    {
        return $this->nom_utl;
    }

    public function setNomUtl(string $nom_utl): self
    {
        $this->nom_utl = $nom_utl;

        return $this;
    }

    public function getPrenomUtl(): ?string
    {
        return $this->prenom_utl;
    }

    public function setPrenomUtl(string $prenom_utl): self
    {
        $this->prenom_utl = $prenom_utl;

        return $this;
    }

    /**
     * @return Collection|Hebergement[]
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }

    public function addHebergement(Hebergement $hebergement): self
    {
        if (!$this->hebergements->contains($hebergement)) {
            $this->hebergements[] = $hebergement;
            $hebergement->setUser($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): self
    {
        if ($this->hebergements->removeElement($hebergement)) {
            // set the owning side to null (unless already changed)
            if ($hebergement->getUser() === $this) {
                $hebergement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReservationHebergement[]
     */
    public function getReservationHebergements(): Collection
    {
        return $this->reservationHebergements;
    }

    public function addReservationHebergement(ReservationHebergement $reservationHebergement): self
    {
        if (!$this->reservationHebergements->contains($reservationHebergement)) {
            $this->reservationHebergements[] = $reservationHebergement;
            $reservationHebergement->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReservationHebergement(ReservationHebergement $reservationHebergement): self
    {
        if ($this->reservationHebergements->removeElement($reservationHebergement)) {
            // set the owning side to null (unless already changed)
            if ($reservationHebergement->getUtilisateur() === $this) {
                $reservationHebergement->setUtilisateur(null);
            }
        }

        return $this;
    }
}
