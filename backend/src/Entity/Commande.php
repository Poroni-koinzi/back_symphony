<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
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
    private $idCommande;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCommande;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Panier", mappedBy="idCommande")
     */
    private $paniers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="idCommande", cascade={"persist", "remove"})
     */
    private $facture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", inversedBy="commande", cascade={"persist", "remove"})
     */
    private $idFacture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Client", inversedBy="commande", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idClient;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Panier", inversedBy="commande", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPanier;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCommande(): ?string
    {
        return $this->idCommande;
    }

    public function setIdCommande(string $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setIdCommande($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->contains($panier)) {
            $this->paniers->removeElement($panier);
            // set the owning side to null (unless already changed)
            if ($panier->getIdCommande() === $this) {
                $panier->setIdCommande(null);
            }
        }

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(Facture $facture): self
    {
        $this->facture = $facture;

        // set the owning side of the relation if necessary
        if ($facture->getIdCommande() !== $this) {
            $facture->setIdCommande($this);
        }

        return $this;
    }

    public function getIdFacture(): ?Facture
    {
        return $this->idFacture;
    }

    public function setIdFacture(?Facture $idFacture): self
    {
        $this->idFacture = $idFacture;

        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(Client $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdPanier(): ?Panier
    {
        return $this->idPanier;
    }

    public function setIdPanier(Panier $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
    }
}
