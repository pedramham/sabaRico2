<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="CategoryVideo")
     * @ORM\JoinColumn(name="idCategory",referencedColumnName="id")
     */
    private $idCategory;
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
     * @ORM\Column(type="string", length=199)
     */
    private $videoLink;
    /**
     * @ORM\Column(type="string", length=199)
     */
    private $duringVideo;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $labelKeyWord;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsert;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counterView;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $urlSlug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdate;

    /**
     * @ORM\Column(type="string", length=199)
     */
    private $authorName;
    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->lastUpdate = new \DateTime();
        $this->setDisplayStatus(true);
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

    public function setSmallPic($smallPic)
    {
        $this->smallPic = $smallPic;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(string $videoLink): self
    {
        $this->videoLink = $videoLink;

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

    public function setDateInsert(\DateTimeInterface $dateInsert): self
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }

    public function getDuringVideo(): ?string
    {
        return $this->duringVideo;
    }
    public function setDuringVideo(?string $duringVideo): self
    {
        $this->duringVideo = $duringVideo;

        return $this;
    }
    public function getCounterView(): ?int
    {
        return $this->counterView;
    }

    public function setCounterView(?int $counterView): self
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

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

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

    /**
     * Set idCategory
     *
     * @param \App\Entity\CategoryVideo $idCategory
     *
     * @return video
     */
    public function setIdCategory(\App\Entity\CategoryVideo $idCategory = null)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return \App\Entity\CategoryVideo
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

}
