<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="idArticle",referencedColumnName="id")
     */
    private $idArticle;
    /**
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumn(name="idNews",referencedColumnName="id")
     */
    private $idNews;
    /**
     *
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="idService",referencedColumnName="id")
     */
    private $idService;
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsert;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $answerAdmin;

    /**
     * @ORM\Column(type="string", length=80,nullable=true)
     */
    private $nameAdmin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAnswer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $displayStatus;
    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->dateAnswer = new \DateTime();
        $this->displayStatus = 0;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getDateInsert(): ?\DateTimeInterface
    {
        return $this->dateInsert;
    }

    public function setDateInsert(\DateTimeInterface $dateInsert): self
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }

    public function getAnswerAdmin(): ?string
    {
        return $this->answerAdmin;
    }

    public function setAnswerAdmin(string $answerAdmin): self
    {
        $this->answerAdmin = $answerAdmin;

        return $this;
    }

    public function getNameAdmin(): ?string
    {
        return $this->nameAdmin;
    }

    public function setNameAdmin(string $nameAdmin): self
    {
        $this->nameAdmin = $nameAdmin;

        return $this;
    }

    public function getDateAnswer(): ?\DateTimeInterface
    {
        return $this->dateAnswer;
    }

    public function setDateAnswer(?\DateTimeInterface $dateAnswer): self
    {
        $this->dateAnswer = $dateAnswer;

        return $this;
    }

    public function getDisplayStatus(): ?bool
    {
        return $this->displayStatus;
    }

    public function setDisplayStatus(?bool $displayStatus): self
    {
        $this->displayStatus = $displayStatus;

        return $this;
    }

    /**
     * Set idArticle
     *
     * @param \App\Entity\Article $idArticle
     *
     * @return comment
     */
    public function setIdArticle(\App\Entity\Article $idArticle = null)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return \App\Entity\Article
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }




    /**
     * Set idNews
     *
     * @param \App\Entity\News $idNews
     *
     * @return comment
     */
    public function setIdNews(\App\Entity\News $idNews = null)
    {
        $this->idNews = $idNews;

        return $this;
    }

    /**
     * Get idNews
     *
     * @return \App\Entity\News
     */
    public function getIdNews()
    {
        return $this->idNews;
    }


    /**
     * Set idService
     *
     * @param \App\Entity\Service $idService
     *
     * @return comment
     */
    public function setIdService(\App\Entity\Service $idService = null)
    {
        $this->idService = $idService;

        return $this;
    }

    /**
     * Get idService
     *
     * @return \App\Entity\Service
     */
    public function getIdService()
    {
        return $this->idService;
    }
}
