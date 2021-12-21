<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Category;
use Collator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    public function __construct()
    {
        $this->productimgs = new ArrayCollection();
    }

    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $illustration;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $subtitle;

     /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $typeOffre;

     /**
     * @var string 
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

     /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $dispoDate;

    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $montantTaxeFonciere;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $montantCharges;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $montantTaxeBureaux;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $codePostal;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $surface;

    /**
     * @var float
     * 
     * @ORM\Column(type="float")
     */
    private $loyer;

    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean",options={"default"="1"},nullable=false)
     */
    private $dispo;

    /**
     * @var Category
     * 
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var Productimg[]
     * 
     *  @ORM\OneToMany(targetEntity=Productimg::class, mappedBy="product")
     */
    private $productimgs;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function gettypeOffre(): ?string
    {
        return $this->typeOffre;
    }

    public function settypeOffre(string $typeOffre): self
    {
        $this->typeOffre = $typeOffre;

        return $this;
    }

    public function getetat(): ?string
    {
        return $this->etat;
    }

    public function setetat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


    public function getdispoDate(): ?string
    {
        return $this->dispoDate;
    }

    public function setdispoDate(string $dispoDate): self
    {
        $this->dispoDate = $dispoDate;

        return $this;
    }


    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getmontantTaxeFonciere(): ?float
    {
        return $this->montantTaxeFonciere;
    }

    public function setmontantTaxeFonciere(float $montantTaxeFonciere): self
    {
        $this->montantTaxeFonciere = $montantTaxeFonciere;

        return $this;
    }


    public function getmontantCharges(): ?float
    {
        return $this->montantCharges;
    }

    public function setmontantCharges(float $montantCharges): self
    {
        $this->montantCharges = $montantCharges;

        return $this;
    }


    public function getmontantTaxeBureaux(): ?float
    {
        return $this->montantTaxeBureaux;
    }

    public function setmontantTaxeBureaux(float $montantTaxeBureaux): self
    {
        $this->montantTaxeBureaux = $montantTaxeBureaux;

        return $this;
    }



    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getCodePostal(): ?float
    {
        return $this->codePostal;
    }

    public function setCodePostal(float $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getLoyer(): ?float
    {
        return $this->loyer;
    }

    public function setLoyer(float $loyer): self
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getDispo(): bool
    {
        return $this->dispo;
    }

    public function setDispo(bool $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Productimg[]
     */
    public function getProductimgs(): array
    {
        return $this->productimgs;
    }
}
