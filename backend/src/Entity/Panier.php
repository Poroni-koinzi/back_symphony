<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier
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
    private $idPanier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="idPanier")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="paniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idClient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="paniers")
     */
    private $idCommande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", mappedBy="idPanier", cascade={"persist", "remove"})
     */
    private $commande;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPanier(): ?string
    {
        return $this->idPanier;
    }

    public function setIdPanier(string $idPanier): self
    {
        $this->idPanier = $idPanier;

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
            $produit->setIdPanier($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getIdPanier() === $this) {
                $produit->setIdPanier(null);
            }
        }

        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(?Commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(Commande $commande): self
    {
        $this->commande = $commande;

        // set the owning side of the relation if necessary
        if ($commande->getIdPanier() !== $this) {
            $commande->setIdPanier($this);
        }

        return $this;
    }
}
