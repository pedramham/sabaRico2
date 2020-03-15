<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentRepository")
 */
class Content
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="CategoryContent")
     * @ORM\JoinColumn(name="idCategory",referencedColumnName="id")
     */
    private $idCategory;
    /**
     * @ORM\Column(name="name",type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="title",type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="description",type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="subject",type="text")
     */
    private $subject;

    /**
     * @ORM\Column(name="descriptionSeo",type="text")
     */
    private $descriptionSeo;

    /**
     * @ORM\Column(name="smallPic",type="string", length=255)
     */
    private $smallPic;

    /**
     * @ORM\Column(name="largePic",type="string", length=255)
     */
    private $largePic;

    /**
     * @ORM\Column(name="labelKeyWord",type="string", length=255)
     */
    private $labelKeyWord;

    /**
     * @ORM\Column(name="displayStatus",type="boolean")
     */
    private $displayStatus;

    /**
     * @ORM\Column(name="dateInsert",type="datetime", nullable=true)
     */
    private $dateInsert;

    /**
     * @ORM\Column(name="counterView",type="integer")
     */
    private $counterView;

    /**
     * @ORM\Column(name="urlSlug",type="string", length=255)
     */
    private $urlSlug;

    /**
     * @ORM\Column(name="authorName",type="string", length=255)
     */
    private $authorName;

    /**
     * @ORM\Column(name="lastUpdate",type="datetime")
     */
    private $lastUpdate;
    /**
     * @ORM\Column(name="panelContent",type="integer", nullable=true)
     */
    private $panelContent;
    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->setDisplayStatus(true);
        $this->lastUpdate = new \DateTime();
        $this->counterView="1";

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function setSmallPic($smallPic)
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

    public function getLabelKeyWord(): ?string
    {
        return $this->labelKeyWord;
    }

    public function setLabelKeyWord(string $labelKeyWord): self
    {
        $this->labelKeyWord = $labelKeyWord;

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

    public function getCounterView(): ?int
    {
        return $this->counterView;
    }

    public function setCounterView(int $counterView): self
    {
        $this->counterView = $counterView;

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
    /**
     * Set idCategory
     *
     * @param \App\Entity\CategoryContent $idCategory
     *
     * @return Article
     */
    public function setIdCategory(\App\Entity\CategoryContent $idCategory = null)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return \App\Entity\CategoryContent
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }
    public function getPanelContent(): ?int
    {
        return $this->panelContent;
    }

    public function setPanelContent(?int $panelContent): self
    {
        $this->panelContent = $panelContent;

        return $this;
    }
}
