<?php

namespace App\Entity;

use App\Repository\InfluenceurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InfluenceurRepository::class)
 */
class Influenceur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(payload={"severity"="error"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(payload={"severity"="error"})
     */
    private $nom;
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    * @Assert\NotBlank(message={"download avatar"})
    * @Assert\File(mimeTypes={"image/jpeg"})
    */
    private $avatar;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $nbrFollowrs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagramPage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookPage;

    /**
     * @ORM\OneToMany(targetEntity=Blog::class, mappedBy="code", orphanRemoval=true)
     */
    private $blogs;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNbrFollowrs(): ?float
    {
        return $this->nbrFollowrs;
    }

    public function setNbrFollowrs(float $nbrFollowrs): self
    {
        $this->nbrFollowrs = $nbrFollowrs;

        return $this;
    }

    public function getInstagramPage(): ?string
    {
        return $this->instagramPage;
    }

    public function setInstagramPage(?string $instagramPage): self
    {
        $this->instagramPage = $instagramPage;

        return $this;
    }

    public function getFacebookPage(): ?string
    {
        return $this->facebookPage;
    }

    public function setFacebookPage(?string $facebookPage): self
    {
        $this->facebookPage = $facebookPage;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
    /**
     * @return Collection<int, Blog>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setCode($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getCode() === $this) {
                $blog->setCode(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (String) $this->getCode();
    }
}
