<?php

namespace App\Entity;

use App\Repository\TypeHebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TypeHebergementRepository::class)
 * @UniqueEntity(
 * fields={"nom_type_hbrg" },
 * message="This name is already used"
 * )
 */
class TypeHebergement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="the name is required")
     * @Assert\Length(
     *      min = 2,
     *      max = 200,
     *      minMessage = "'nom' must be at least {{ limit }} characters long",
     *      maxMessage = "'nom' cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom_type_hbrg;

    /**
     * @ORM\OneToMany(targetEntity=Hebergement::class, mappedBy="type_hbrg",cascade={"all"},orphanRemoval=true)
     */
    private $hebergements;

    public function __construct()
    {
        $this->hebergements = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeHbrg(): ?string
    {
        return $this->nom_type_hbrg;
    }

    public function setNomTypeHbrg(string $nom): self
    {
        $this->nom_type_hbrg = $nom;

        return $this;
    }

    /**
     * @return Collection|Hebergement[]
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }


 
}
