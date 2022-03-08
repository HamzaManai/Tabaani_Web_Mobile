<?php

namespace App\Entity;

use App\Entity\Proprietaire;
use App\Repository\HebergementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @ORM\Entity(repositoryClass=HebergementRepository::class)
 */
class Hebergement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom is required")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "'nom' must be at least {{ limit }} characters long",
     *      maxMessage = "'nom' cannot be longer than {{ limit }} characters"
     * )
     * @Groups("post:read")

     */
    private $nom_hbrg;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "'nom' must be at least {{ limit }} characters long",
     *      maxMessage = "'nom' cannot be longer than {{ limit }} characters"
     * )
     * @Groups("post:read")
    
     */
    private $adresse_hbrg;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="nombre de place is required" )
     * @Assert\NotEqualTo("0")
     * @Assert\GreaterThan("0")
     * @Assert\Positive(message="le numero de telephone doit etre positif")
     * @Groups("post:read")
     
     */
    private $nbr_place_hbrg;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="la date doit etre au format jj/mm/aaaa")
     * @Assert\GreaterThan("+1 minute")
     * @Groups("post:read")
     */
    private $date_hbrg;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="image principal is required" )
     * Groups("post:read")
     */
    private $img_hbrg;

    /**
     * @ORM\ManyToOne(targetEntity=proprietaire::class, inversedBy="hebergements")
     * Groups("post:read")
     */
    private $proprietaire;

    /**
     * @ORM\ManyToOne(targetEntity=TypeHebergement::class, inversedBy="hebergements")
     * @Assert\NotBlank(message="type de Hebergement is required" )
     * Groups("post:read")

     */
    private $type_hbrg;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="hebergements")
     * Groups("post:read")

     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="prix is required" )
     * Groups("post:read")

     */
    private $prix_hbrg;

    /**
     * @ORM\OneToMany(targetEntity=ImagesHebergement::class, mappedBy="hebergement", orphanRemoval=true , cascade={"persist"})
     */
    private $imagesHebergements;

    /**
     * @ORM\OneToMany(targetEntity=ReservationHebergement::class, mappedBy="hebergement",cascade={"all"},orphanRemoval=true)
     */
    private $reservationHebergements;

    protected $captchaCode;
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }
    public function __construct()
    {
        $this->imagesHebergements = new ArrayCollection();
        $this->reservationHebergements = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomHbrg(): ?string
    {
        return $this->nom_hbrg;
    }

    public function setNomHbrg(string $nom_hbrg): self
    {
        $this->nom_hbrg = $nom_hbrg;

        return $this;
    }

    public function getAdresseHbrg(): ?string
    {
        return $this->adresse_hbrg;
    }

    public function setAdresseHbrg(string $adresse_hbrg): self
    {
        $this->adresse_hbrg = $adresse_hbrg;

        return $this;
    }

    public function getNbrPlaceHbrg(): ?int
    {
        return $this->nbr_place_hbrg;
    }

    public function setNbrPlaceHbrg(int $nbr_place_hbrg): self
    {
        $this->nbr_place_hbrg = $nbr_place_hbrg;

        return $this;
    }

    public function getImgHbrg()
    {
        return $this->img_hbrg;
    }

    public function setImgHbrg($img_hbrg)
    {
        $this->img_hbrg = $img_hbrg;

        return $this;
    }

    public function getDateHbrg(): ?\DateTimeInterface
    {
        return $this->date_hbrg;
    }

    public function setDateHbrg(\DateTimeInterface $date_hbrg): self
    {
        $this->date_hbrg  = $date_hbrg;
        return $this;
    }

    public function getProprietaire(): ?proprietaire
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?proprietaire $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getTypeHbrg(): ?TypeHebergement
    {
        return $this->type_hbrg;
    }

    public function setTypeHbrg(?TypeHebergement $type_hbrg): self
    {
        $this->type_hbrg = $type_hbrg;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrixHbrg(): ?int
    {
        return $this->prix_hbrg;
    }

    public function setPrixHbrg(?int $prix_hbrg): self
    {
        $this->prix_hbrg = $prix_hbrg;

        return $this;
    }

    /**
     * @return Collection|ImagesHebergement[]
     */
    public function getImagesHebergements(): Collection
    {
        return $this->imagesHebergements;
    }

    public function addImagesHebergement(ImagesHebergement $imagesHebergement): self
    {
        if (!$this->imagesHebergements->contains($imagesHebergement)) {
            $this->imagesHebergements[] = $imagesHebergement;
            $imagesHebergement->setHebergement($this);
        }

        return $this;
    }

    public function removeImagesHebergement(ImagesHebergement $imagesHebergement): self
    {
        if ($this->imagesHebergements->removeElement($imagesHebergement)) {
            // set the owning side to null (unless already changed)
            if ($imagesHebergement->getHebergement() === $this) {
                $imagesHebergement->setHebergement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReservationHebergement[]
     */
    public function getReservationHebergements(): Collection
    {
        return $this->reservationHebergements;
    }

    public function addReservationHebergement(ReservationHebergement $reservationHebergement): self
    {
        if (!$this->reservationHebergements->contains($reservationHebergement)) {
            $this->reservationHebergements[] = $reservationHebergement;
            $reservationHebergement->setHebergement($this);
        }

        return $this;
    }

    public function removeReservationHebergement(ReservationHebergement $reservationHebergement): self
    {
        if ($this->reservationHebergements->removeElement($reservationHebergement)) {
            // set the owning side to null (unless already changed)
            if ($reservationHebergement->getHebergement() === $this) {
                $reservationHebergement->setHebergement(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        //$newDate = DateTime::createFromFormat("l dS F Y", $this->date_hbrg);
       // $newDate = $newDate->format('d/m/Y'); // for example
       //$this->date_hbrg->setDateTime(\DateTime::createFromFormat('d-m-Y H:i', $date.' '.$time));

        return $this->nom_hbrg . $this->adresse_hbrg  . $this->nbr_place_hbrg . $this->prix_hbrg 
        . $this->type_hbrg . $this->user . $this->proprietaire;
    }
}
