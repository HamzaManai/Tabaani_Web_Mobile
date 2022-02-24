<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
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
    private $eventname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\NotEqualTo(
     *     value = 0
     * )
     */
    private $nbrmaxpart;

    /*/**
     * @ORM\Column(type="integer", nullable=true)
     */
    //private $nbrpart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $imageevent;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Your event's description must be at least {{ limit }} characters long"
     * )
     */
    private $description;

    /*/**
     * @ORM\Column(type="string", length=255)
     */
    //private $format;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $eventdate;

    /*/**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    //private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Your event's address must be at least {{ limit }} characters long"
     * )
     */
    private $eventaddress;

    /**
     * @ORM\ManyToOne(targetEntity=Themes::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $eventtheme;

    /*/**
     * @ORM\OneToOne(targetEntity=EventProgram::class, inversedBy="events", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    //private $eventprog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventname(): ?string
    {
        return $this->eventname;
    }

    public function setEventname(string $eventname): self
    {
        $this->eventname = $eventname;

        return $this;
    }

    public function getNbrmaxpart(): ?int
    {
        return $this->nbrmaxpart;
    }

    public function setNbrmaxpart(int $nbrmaxpart): self
    {
        $this->nbrmaxpart = $nbrmaxpart;

        return $this;
    }

    /*public function getNbrpart(): ?int
    {
        return $this->nbrpart;
    }

    public function setNbrpart(?int $nbrpart): self
    {
        $this->nbrpart = $nbrpart;

        return $this;
    }*/

    public function getImageevent(): ?string
    {
        return $this->imageevent;
    }

    public function setImageevent(string $imageevent): self
    {
        $this->imageevent = $imageevent;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /*public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }*/

    public function getEventdate(): ?\DateTimeInterface
    {
        return $this->eventdate;
    }

    public function setEventdate(\DateTimeInterface $eventdate): self
    {
        $this->eventdate = $eventdate;

        return $this;
    }

    /*public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }*/

    public function getEventaddress(): ?string
    {
        return $this->eventaddress;
    }

    public function setEventaddress(?string $eventaddress): self
    {
        $this->eventaddress = $eventaddress;

        return $this;
    }

    public function getEventtheme(): ?Themes
    {
        return $this->eventtheme;
    }

    public function setEventtheme(?Themes $eventtheme): self
    {
        $this->eventtheme = $eventtheme;

        return $this;
    }

    /*public function getEventprog(): ?EventProgram
    {
        return $this->eventprog;
    }

    public function setEventprog(EventProgram $eventprog): self
    {
        $this->eventprog = $eventprog;

        return $this;
    }*/
}
