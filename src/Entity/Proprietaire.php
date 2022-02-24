<?php

namespace App\Entity;

use App\Repository\ProprietaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=ProprietaireRepository::class)
 * @UniqueEntity(
 * fields={"email_prop"},
 * message="This email  is already used"
 * ) 
 * @UniqueEntity(
 * fields={"num_tlf_prop"},
 * message="this phone number is already used"
 * )
 */

class Proprietaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     */
    private $nom_prop;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="prenom is required")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "'prenom' must be at least {{ limit }} characters long",
     *      maxMessage = "'prenom' cannot be longer than {{ limit }} characters"
     * )
     */
    private $prenom_prop;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="email is required")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     *  )
     */
    private $email_prop;

    /**
     * @ORM\Column(type="integer",length="8")
     * @Assert\NotBlank(message="numero de telephone is required" )
     * @Assert\NotEqualTo("00000000")
     * @Assert\Positive(message="le numero de telephone doit etre positif")
     * @Assert\Length(
     *    min = 8,
     *    max = 8,   
     *    minMessage = "'numero de telephone' must be at least {{ limit }} characters long",
     *    maxMessage = "'numero de telephone' cannot be longer than {{ limit }} characters"
     * )
     */
    private $num_tlf_prop;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Please upload image")
     */
    private $img_prop;

    /**
     * @ORM\OneToMany(targetEntity=Hebergement::class, mappedBy="proprietaire")
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

    public function getNomProp(): ?string
    {
        return $this->nom_prop;
    }

    public function setNomProp(string $nom_prop): self
    {
        $this->nom_prop = $nom_prop;

        return $this;
    }

    public function getPrenomProp(): ?string
    {
        return $this->prenom_prop;
    }

    public function setPrenomProp(string $prenom_prop): self
    {
        $this->prenom_prop = $prenom_prop;

        return $this;
    }

    public function getEmailProp(): ?string
    {
        return $this->email_prop;
    }

    public function setEmailProp(string $email_prop): self
    {
        $this->email_prop = $email_prop;

        return $this;
    }

    public function getNumTlfProp(): ?int
    {
        return $this->num_tlf_prop;
    }

    public function setNumTlfProp(int $num_tlf_prop): self
    {
        $this->num_tlf_prop = $num_tlf_prop;

        return $this;
    }

    public function getImgProp()
    {
        return $this->img_prop;
    }

    public function setImgProp( $img_prop)
    {
        $this->img_prop = $img_prop;

        return $this;
    }

    /**
     * @return Collection|Hebergement[]
     */
    public function getHebergements(): Collection
    {
        return $this->hebergements;
    }

    public function addHebergement(Hebergement $hebergement): self
    {
        if (!$this->hebergements->contains($hebergement)) {
            $this->hebergements[] = $hebergement;
            $hebergement->setProprietaire($this);
        }

        return $this;
    }

    public function removeHebergement(Hebergement $hebergement): self
    {
        if ($this->hebergements->removeElement($hebergement)) {
            // set the owning side to null (unless already changed)
            if ($hebergement->getProprietaire() === $this) {
                $hebergement->setProprietaire(null);
            }
        }

        return $this;
    }

}
