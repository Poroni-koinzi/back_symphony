<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $idCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="idCategory", orphanRemoval=true)
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategory(): ?string
    {
        return $this->idCategory;
    }

    public function setIdCategory(string $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getLibelleCategory(): ?string
    {
        return $this->libelleCategory;
    }

    public function setLibelleCategory(string $libelleCategory): self
    {
        $this->libelleCategory = $libelleCategory;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setIdCategory($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getIdCategory() === $this) {
                $produit->setIdCategory(null);
            }
        }

        return $this;
    }


}

