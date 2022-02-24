<?php

namespace App\Entity;

use App\Repository\ImagesHebergementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesHebergementRepository::class)
 */
class ImagesHebergement
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
    private $nom_img;

    /**
     * @ORM\ManyToOne(targetEntity=hebergement::class, inversedBy="imagesHebergements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hebergement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImg(): ?string
    {
        return $this->nom_img;
    }

    public function setNomImg(string $nom_img): self
    {
        $this->nom_img = $nom_img;

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
}
