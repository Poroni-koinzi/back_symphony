<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idProduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleProduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoProduit;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionProduit;

    /**
     * @ORM\Column(type="float")
     */
    private $prixProduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteStockProduit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panier", inversedBy="produits")
     */
    private $idPanier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="idProduit", orphanRemoval=true)
     */
    private $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?string
    {
        return $this->idProduit;
    }

    public function setIdProduit(string $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getLibelleProduit(): ?string
    {
        return $this->libelleProduit;
    }

    public function setLibelleProduit(string $libelleProduit): self
    {
        $this->libelleProduit = $libelleProduit;

        return $this;
    }

    public function getPhotoProduit(): ?string
    {
        return $this->photoProduit;
    }

    public function setPhotoProduit(string $photoProduit): self
    {
        $this->photoProduit = $photoProduit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->descriptionProduit;
    }

    public function setDescriptionProduit(string $descriptionProduit): self
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getQuantiteStockProduit(): ?int
    {
        return $this->quantiteStockProduit;
    }

    public function setQuantiteStockProduit(int $quantiteStockProduit): self
    {
        $this->quantiteStockProduit = $quantiteStockProduit;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Category $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getIdPanier(): ?Panier
    {
        return $this->idPanier;
    }

    public function setIdPanier(?Panier $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setIdProduit($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->contains($avi)) {
            $this->avis->removeElement($avi);
            // set the owning side to null (unless already changed)
            if ($avi->getIdProduit() === $this) {
                $avi->setIdProduit(null);
            }
        }

        return $this;
    }
}
