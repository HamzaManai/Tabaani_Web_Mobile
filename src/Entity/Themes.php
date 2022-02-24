<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your event's name must be at least {{ limit }} characters long",
     *      maxMessage = "Your event's name cannot be longer than {{ limit }} characters"
     * )
     */
    private $themename;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Your event's description must be at least {{ limit }} characters long"
     * )
     */
    private $imagetheme;

    /**
     * @ORM\OneToMany(targetEntity=Events::class, mappedBy="eventtheme", cascade={"all"}, orphanRemoval=true)
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

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

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setEventtheme($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getEventtheme() === $this) {
                $event->setEventtheme(null);
            }
        }

        return $this;
    }
}
