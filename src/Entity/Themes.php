<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemesRepository::class)
 */
class Themes
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
    private $themename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagetheme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThemename(): ?string
    {
        return $this->themename;
    }

    public function setThemename(string $themename): self
    {
        $this->themename = $themename;

        return $this;
    }

    public function getImagetheme(): ?string
    {
        return $this->imagetheme;
    }

    public function setImagetheme(string $imagetheme): self
    {
        $this->imagetheme = $imagetheme;

        return $this;
    }
}
