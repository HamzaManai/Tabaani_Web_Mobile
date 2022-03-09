<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class InfluenceurSearch
{

   private $nom;
   private $email;
    private $code;
   private $instagramPage;
   private $facebookPage;
   
   public function getEmail(): ?string
   {
       return $this->email;
   }

   public function setEmail(string $email): self
   {
       $this->nom = $email;

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

   public function getCode(): ?int
   {
       return $this->code;
   }

   public function setCode(int $code): self
   {
       $this->code = $code;

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
    public function __toString()
    {
        return (String) $this->getCode();
    }
}