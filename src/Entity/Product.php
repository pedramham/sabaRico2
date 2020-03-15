<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="CategoryProduct")
     * @ORM\JoinColumn(name="idCategoryProduct",referencedColumnName="id")
     */
    private $idCategoryProduct;
    /**
     * @ORM\Column(type="string", length=200)
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
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     */
    private $urlSlug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $manufacturingCountry;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $brand;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $guarantee;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $periodGuarantee;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $sellerTelephone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyImporter;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $productCode;
    /**
     * @ORM\Column(name="panelLastProduct",type="integer", nullable=true)
     */
    private $panelLastProduct;
    public function __construct()
    {
        $this->dateInsert = new \DateTime();
        $this->setDisplayStatus(true);
        $this->lastUpdate = new \DateTime();

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellerTelephone(): ?string
    {
        return $this->sellerTelephone;
    }
    public function setSellerTelephone(string $sellerTelephone): self
    {
        $this->sellerTelephone = $sellerTelephone;

        return $this;
    }


    public function getPeriodGuarantee(): ?\DateTimeInterface
    {
        return $this->periodGuarantee;
    }

    public function setPeriodGuarantee(\DateTimeInterface $periodGuarantee): self
    {
        $this->periodGuarantee = $periodGuarantee;

        return $this;
    }

    public function getGuarantee(): ?string
    {
        return $this->guarantee;
    }
    public function setGuarantee(string $guarantee): self
    {
        $this->guarantee = $guarantee;

        return $this;
    }
    public function getBrand(): ?string
    {
        return $this->brand;
    }
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
    public function getManufacturingCountry(): ?string
    {
        return $this->manufacturingCountry;
    }
    public function setManufacturingCountry(string $manufacturingCountry): self
    {
        $this->manufacturingCountry = $manufacturingCountry;

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

    public function setSmallPic($smallPic)
    {
        $this->smallPic = $smallPic;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
    /**
     * Set idCategoryProduct
     *
     * @param \App\Entity\CategoryProduct $CategoryProduct
     *
     * @return Product
     */
    public function setIdCategoryProduct(\App\Entity\CategoryProduct $idCategoryProduct = null)
    {
        $this->idCategoryProduct = $idCategoryProduct;

        return $this;
    }

    /**
     * Get idCategoryProduct
     *
     * @return \App\Entity\CategoryProduct
     */
    public function getIdCategoryProduct()
    {
        return $this->idCategoryProduct;
    }

    public function getPanelLastProduct(): ?int
    {
        return $this->panelLastProduct;
    }

    public function setPanelLastProduct(?int $panelLastProduct): self
    {
        $this->panelLastProduct = $panelLastProduct;

        return $this;
    }



    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): self
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getCompanyImporter(): ?string
    {
        return $this->companyImporter;
    }

    public function setCompanyImporter(string $companyImporter): self
    {
        $this->companyImporter = $companyImporter;

        return $this;
    }
}
