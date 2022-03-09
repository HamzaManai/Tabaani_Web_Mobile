<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;
   
   /**
    * @Assert\DateTime()
    * @ORM\Column(type="datetime")
    */
    private $dateComment;
    /**
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="commentaires")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id",nullable=false)
     */
    private $Blog;
    
    /**
     * Get blogid
     * @return integer
     */
    public function getBlogId(): ?Blog
    {
        return $this->blog_id;
    }
    
    public function setBlogId(?Blog $blog_id): self
    {
        $this->blog_id = $blog_id;

        return $this;
    }
    public function getDateComment(): ?\DateTimeInterface
    {
        

        return $this->dateComment;
    }

    public function setDateComment()
    {
        // WILL be saved in the database
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
    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
    public function getBlog(): ?blog
    {
        return $this->Blog;
    }

    public function setBlog(?blog $Blog): self
    {
        $this->Blog = $Blog;

        return $this;
    }
     /**
    * Transform to string
    * 
    * @return string
    */
    public function __toString()
    {
        return (String) $this->getDateComment();
    }
   
    
}
