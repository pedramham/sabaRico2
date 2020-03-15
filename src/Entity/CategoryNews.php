<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryNews
 *
 * @ORM\Table(name="category_news")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryNewsRepository")
 */
class CategoryNews
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text")
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @ORM\Column(name="descriptionSeo", type="text")
     * @var string
     */
    private $descriptionSeo;
    /**
     * @var string
     *
     * @ORM\Column(name="smallPic", type="string", length=255)
     */
    private $smallPic;

    /**
     * @var string
     *
     * @ORM\Column(name="largPic", type="string", length=255)
     */
    private $largPic;

    /**
     * @var bool
     *
     * @ORM\Column(name="displayStatus", type="boolean")
     */
    private $displayStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInsert", type="datetime")
     */
    private $dateInsert;
    /**
     * @var string
     *
     * @ORM\Column(name="labelKeyWord", type="text",nullable=true)
     */
    private $labelKeyWord;
    /**
     * @var string
     *
     * @ORM\Column(name="urlSlug", type="string", length=255)
     */
    private $urlSlug;
    /**
     * @ORM\Column(name="panelNewsCategory",type="integer", nullable=true)
     */
    private $panelNewsCategory;

    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->setDisplayStatus(true);

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CategoryNews
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return CategoryNews
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return CategoryNews
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CategoryNews
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set smallPic
     *
     * @param string $smallPic
     *
     * @return CategoryNews
     */
    public function setSmallPic($smallPic)
    {
        $this->smallPic = $smallPic;

        return $this;
    }

    /**
     * Get smallPic
     *
     * @return string
     */
    public function getSmallPic()
    {
        return $this->smallPic;
    }

    /**
     * Set largPic
     *
     * @param string $largPic
     *
     * @return CategoryNews
     */
    public function setLargPic($largPic)
    {
        $this->largPic = $largPic;

        return $this;
    }

    /**
     * Get largPic
     *
     * @return string
     */
    public function getLargPic()
    {
        return $this->largPic;
    }

    /**
     * Set displayStatus
     *
     * @param boolean $displayStatus
     *
     * @return CategoryNews
     */
    public function setDisplayStatus($displayStatus)
    {
        $this->displayStatus = $displayStatus;

        return $this;
    }

    /**
     * Get displayStatus
     *
     * @return bool
     */
    public function getDisplayStatus()
    {
        return $this->displayStatus;
    }

    /**
     * Set dateInsert
     *
     * @param \DateTime $dateInsert
     *
     * @return CategoryNews
     */
    public function setDateInsert($dateInsert)
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }

    /**
     * Get dateInsert
     *
     * @return \DateTime
     */
    public function getDateInsert()
    {
        return $this->dateInsert;
    }

    /**
     * Set descriptionSeo
     *
     * @param string $descriptionSeo
     *
     * @return CategoryNews
     */
    public function setDescriptionSeo($descriptionSeo)
    {
        $this->descriptionSeo = $descriptionSeo;

        return $this;
    }

    /**
     * Get descriptionSeo
     *
     * @return string
     */
    public function getDescriptionSeo()
    {
        return $this->descriptionSeo;
    }

    /**
     * Set labelKeyWord
     *
     * @param string $labelKeyWord
     *
     * @return CategoryNews
     */
    public function setLabelKeyWord($labelKeyWord)
    {
        $this->labelKeyWord = $labelKeyWord;

        return $this;
    }

    /**
     * Get labelKeyWord
     *
     * @return string
     */
    public function getLabelKeyWord()
    {
        return $this->labelKeyWord;
    }

    /**
     * Set urlSlug
     *
     * @param string $urlSlug
     *
     * @return CategoryNews
     */
    public function setUrlSlug($urlSlug)
    {
        $this->urlSlug = $urlSlug;

        return $this;
    }

    /**
     * Get urlSlug
     *
     * @return string
     */
    public function getUrlSlug()
    {
        return $this->urlSlug;
    }



    public function getPanelNewsCategory(): ?int
    {
        return $this->panelNewsCategory;
    }

    public function setPanelNewsCategory(?int $panelNewsCategory): self
    {
        $this->panelNewsCategory = $panelNewsCategory;

        return $this;
    }
}
