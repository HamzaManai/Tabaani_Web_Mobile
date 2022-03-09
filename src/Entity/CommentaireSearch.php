<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class CommentaireSearch
{
    private $comment;
    private $dateComment;
    private $id;
    private $blog;
    
    public function getDateComment()
    {
        return $this->dateComment;
    }
    public function setDateComment()
    {
    
        $this->dateComment = new \DateTime("now");
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

  
    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

}