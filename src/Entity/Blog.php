<?php

namespace App\Entity;
use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(payload={"severity"="error"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createat;
    
    /**
     * @var bool
    */
    private $localized = false;
    /**
     * @ORM\Column(type="integer")
     */
    private $jaime;

    /**
     * @ORM\Column(type="integer")
     */
    private $detester;
     /**
     * @ORM\Column(type="integer")
     */
    private $nbvue;

    public function getJaime(): ?int
    {
        return $this->jaime;
    }

    public function setJaime(int $jaime): self
    {
        $this->jaime = $jaime;

        return $this;
    }

    public function getDetester(): ?int
    {
        return $this->detester;
    }

    public function setDetester(int $detester): self
    {
        $this->detester = $detester;

        return $this;
    }
    public function getNbvue(): ?int
    {
        return $this->nbvue;
    }

    public function setNbvue(int $nbvue): self
    {
        $this->nbvue = $nbvue;

        return $this;
    }
    /**
     * @ORM\ManyToOne(targetEntity=Influenceur::class, inversedBy="blogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="Blog", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCode(): ?influenceur
    {   
        return $this->code;
    }

    public function setCode(?influenceur $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get Createat
     *
     * @return \DateTime 
     */
    public function getCreateat(): ?\DateTimeInterface
    {
        return $this->createat;
    }

 
    public function setCreateat()
    {
        // WILL be saved in the database
        $this->createat = new \DateTime("now");
    }

  /*  public function convertToDatabaseValue($value, AbstractPlatform $app)
    {
        if ($value instanceof \DateTime) {
            $value->setTimezone(self::getCreateat());
        }

        return parent::convertToDatabaseValue($value, $app);
    }*/

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setBlog($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBlog() === $this) {
                $commentaire->setBlog(null);
            }
        }

        return $this;
    }
    /**
    * Transform to string
    * 
    * @return string
    */
    public function __toString()
    {
        return (String) $this->getCode();
    }
}
