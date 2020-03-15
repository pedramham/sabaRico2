<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryProductRepository")
 */
class CategoryProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="CategoryGeneralProduct")
     * @ORM\JoinColumn(name="idCategoryGeneralProduct",referencedColumnName="id")
     */
    private $idCategoryGeneralProduct;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionSeo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $smallPic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $largePic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsert;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelKeyWord;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlSlug;
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getDescriptionSeo(): ?string
    {
        return $this->descriptionSeo;
    }

    public function setDescriptionSeo(string $descriptionSeo): self
    {
        $this->descriptionSeo = $descriptionSeo;

        return $this;
    }

    public function getSmallPic()
    {
        return $this->smallPic;
    }

    public function setSmallPic( $smallPic)
    {
        $this->smallPic = $smallPic;

        return $this;
    }

    public function getLargePic()
    {
        return $this->largePic;
    }

    public function setLargePic($largePic)
    {
        $this->largePic = $largePic;

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

    public function setDateInsert(\DateTimeInterface $dateInsert): self
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }

    public function getLabelKeyWord(): ?string
    {
        return $this->labelKeyWord;
    }

    public function setLabelKeyWord(string $labelKeyWord): self
    {
        $this->labelKeyWord = $labelKeyWord;

        return $this;
    }

    public function getUrlSlug(): ?string
    {
        return $this->urlSlug;
    }

    public function setUrlSlug(string $urlSlug): self
    {
        $this->urlSlug = $urlSlug;

        return $this;
    }
    /**
     * Set idCategoryGeneralProduct
     *
     * @param \App\Entity\CategoryGeneralProduct $CategoryGeneralProduct
     *
     * @return CategoryProduct
     */
    public function setIdCategoryGeneralProduct(\App\Entity\CategoryGeneralProduct $idCategoryGeneralProduct = null)
    {
        $this->idCategoryGeneralProduct = $idCategoryGeneralProduct;

        return $this;
    }

    /**
     * Get idCategoryGeneralProduct
     *
     * @return \App\Entity\CategoryGeneralProduct
     */
    public function getIdCategoryGeneralProduct()
    {
        return $this->idCategoryGeneralProduct;
    }
}
