<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Assert\Type(
     *      type = "\DateTime",
     *      message = "Event date is not valid",
     * )
     * @Assert\GreaterThanOrEqual(
     *      value = "today",
     *     )
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

    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     */
    private $org;



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

    public function getImageevent()
    {
        return $this->imageevent;
    }

    public function setImageevent($imageevent): self
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

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function getUploadDir()
    {
        return 'imagesEvent';
    }

    public function getAbsolutRoot()
    {
        return $this->getUploadRoot().$this->imageevent ;
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->imageevent;
    }

    public function getUploadRoot()
    {
        return __DIR__.'/../../public/'.$this->getUploadDir().'/';
    }

    public function upload()
    {

        if($this->file === null){
            return;

        }
        $this->imageevent = $this->file->getClientOriginalName();
        if(!is_dir($this->getUploadRoot()))
        {
            mkdir($this->getUploadRoot(),'0777',true);
        }

        $this->file->move($this->getUploadRoot(),$this->imageevent);
        unset($this->file);
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




}
