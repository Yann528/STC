<?php

namespace App\Entity;

use App\Entity\Product;
use App\Repository\ProductimgRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass=ProductimgRepository::class)
 */
class Productimg
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null
     * 
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     * 
     *  @ORM\Column(type="string", length=255, nullable=false)
     */
    private $photos;

    /**
     * @var Product
     * 
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productimgs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getPhotos(): string
    {
        return $this->photos;
    }

    public function setPhotos(string $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
