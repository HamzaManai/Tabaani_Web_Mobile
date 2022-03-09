<?php

namespace App\Entity;

use App\Repository\CarteFideliteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteFideliteRepository::class)
 */
class CarteFidelite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrPoint;

    /**
     * @ORM\OneToOne(targetEntity=Users::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $relation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrPoint(): ?int
    {
        return $this->nbrPoint;
    }

    public function setNbrPoint(int $nbrPoint): self
    {
        $this->nbrPoint = $nbrPoint;

        return $this;
    }

    public function getRelation(): ?Users
    {
        return $this->relation;
    }

    public function setRelation(Users $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
