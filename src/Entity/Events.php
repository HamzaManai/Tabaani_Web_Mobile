<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @Assert\NotBlank(message="Please Write Event Name")
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

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image ")
     * @Assert\File
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


    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Event date is not valid",
     * )
     * @Assert\GreaterThanOrEqual(
     *      value = "today",
     *     )
     */
    private $eventdate;


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

    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     */
    private $org;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_going=0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_likes=0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbr_dislikes=0;



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

    public function getImageevent()
    {
        return $this->imageevent;
    }

    public function setImageevent($imageevent)
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


    public function getEventdate(): ?\DateTimeInterface
    {
        return $this->eventdate;
    }

    public function setEventdate(\DateTimeInterface $eventdate): self
    {
        $this->eventdate = $eventdate;

        return $this;
    }


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


    public function getOrg(): ?User
    {
        return $this->org;
    }

    public function setOrg(?User $org): self
    {
        $this->org = $org;

        return $this;
    }

    public function getNbrGoing(): ?int
    {
        return $this->nbr_going;
    }

    public function setNbrGoing(?int $nbr_going): self
    {
        $this->nbr_going = $nbr_going;

        return $this;
    }

    public function getNbrLikes(): ?int
    {
        return $this->nbr_likes;
    }

    public function setNbrLikes(?int $nbr_likes): self
    {
        $this->nbr_likes = $nbr_likes;

        return $this;
    }

    public function getNbrDislikes(): ?int
    {
        return $this->nbr_dislikes;
    }

    public function setNbrDislikes(?int $nbr_dislikes): self
    {
        $this->nbr_dislikes = $nbr_dislikes;

        return $this;
    }

    public function __toString(): string {
        return $this->eventname;
    }


}
