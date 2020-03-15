<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageGalleryRepository")
 */
class ImageGallery
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
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="idProduct",referencedColumnName="id")
     */
    private $idProduct;
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file;
    /**
     * @ORM\Column(name="displayStatus",type="boolean")
     */
    private $displayStatus;

    /**
     * @ORM\Column(name="dateInsert",type="datetime", nullable=true)
     */
    private $dateInsert;
    /**
     * @ORM\Column(type="text")
     */
    private $subject;
    /**
     * @ORM\Column(name="displayPriority",type="integer", nullable=true)
     */
    private $displayPriority;
    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->setDisplayStatus(true);

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

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

    public function getDisplayStatus(): ?bool
    {
        return $this->displayStatus;
    }

    public function setDisplayStatus(bool $displayStatus): self
    {
        $this->displayStatus = $displayStatus;

        return $this;
    }

    public function getDateInsert(): ?\DateTimeInterface
    {
        return $this->dateInsert;
    }

    public function setDateInsert(?\DateTimeInterface $dateInsert): self
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }
    /**
     * Set idArticle
     *
     * @param \App\Entity\Article $idArticle
     *
     * @return ImageGallery
     */
    public function setIdArticle(\App\Entity\Article $idArticle = null)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return \App\Entity\ImageGallery
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }


    /**
     * Set idProduct
     *
     * @param \App\Entity\Product $idProduct
     *
     * @return ImageGallery
     */
    public function setIdProduct(\App\Entity\Product $idProduct = null)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return \App\Entity\ImageGallery
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set idNews
     *
     * @param \App\Entity\News $idNews
     *
     * @return ImageGallery
     */
    public function setIdNews(\App\Entity\News $idNews = null)
    {
        $this->idNews = $idNews;

        return $this;
    }

    /**
     * Get idNews
     *
     * @return \App\Entity\ImageGallery
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
     * @return ImageGallery
     */
    public function setIdService(\App\Entity\Service $idService = null)
    {
        $this->idService = $idService;

        return $this;
    }

    /**
     * Get idService
     *
     * @return \App\Entity\ImageGallery
     */
    public function getIdService()
    {
        return $this->idService;
    }
    public function getDisplayPriority(): ?int
    {
        return $this->displayPriority;
    }

    public function setDisplayPriority(?int $displayPriority): self
    {
        $this->displayPriority = $displayPriority;

        return $this;
    }
}
