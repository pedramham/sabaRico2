<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryVideoRepository")
 */
class CategoryVideo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=199)
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
     * @ORM\Column(type="string", length=199)
     */
    private $smallPic;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $largePic;
    /**
     * @ORM\Column(type="string", length=199)
     */
    private $codeColorBrand;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsert;

    /**
     * @ORM\Column(type="text")
     */
    private $labelKeyWord;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $urlSlug;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $authorName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdate;
    public function __construct()
    {
        $this->lastUpdate = new \DateTime();
        $this->dateInsert = new \DateTime();
        $this->setDisplayStatus(true);

    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCodeColorBrand(): ?string
    {
        return $this->codeColorBrand;
    }

    public function setCodeColorBrand(string $codeColorBrand): self
    {
        $this->codeColorBrand = $codeColorBrand;

        return $this;
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

    public function setLargePic( $largePic)
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

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }
}
