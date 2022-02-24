<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $pourcent_prom;

    /**
     * @ORM\OneToOne(targetEntity=Voyage::class, inversedBy="promotion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentProm(): ?float
    {
        return $this->pourcent_prom;
    }

    public function setPourcentProm(float $pourcent_prom): self
    {
        $this->pourcent_prom = $pourcent_prom;

        return $this;
    }

    public function getVoyage(): ?Voyage
    {
        return $this->voyage;
    }

    public function setVoyage(Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }
}
