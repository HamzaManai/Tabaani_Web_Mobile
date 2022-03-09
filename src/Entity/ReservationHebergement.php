<?php

namespace App\Entity;

use App\Repository\ReservationHebergementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationHebergementRepository::class)
 */
class ReservationHebergement
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
    private $num_resrv;

    /**
     * @ORM\ManyToOne(targetEntity=hebergement::class, inversedBy="reservationHebergements")
     */
    private $hebergement;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reservationHebergements")
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumResrv(): ?string
    {
        return $this->num_resrv;
    }

    public function setNumResrv(string $num_resrv): self
    {
        $this->num_resrv = $num_resrv;

        return $this;
    }

    public function getHebergement(): ?hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(?hebergement $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
