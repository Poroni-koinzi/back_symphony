<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
    private $idFacture;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFature;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", inversedBy="facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCommande;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", mappedBy="idFacture", cascade={"persist", "remove"})
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFacture(): ?string
    {
        return $this->idFacture;
    }

    public function setIdFacture(string $idFacture): self
    {
        $this->idFacture = $idFacture;

        return $this;
    }

    public function getDateFature(): ?\DateTimeInterface
    {
        return $this->dateFature;
    }

    public function setDateFature(\DateTimeInterface $dateFature): self
    {
        $this->dateFature = $dateFature;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->idCommande;
    }

    public function setIdCommande(Commande $idCommande): self
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        // set (or unset) the owning side of the relation if necessary
        $newIdFacture = null === $commande ? null : $this;
        if ($commande->getIdFacture() !== $newIdFacture) {
            $commande->setIdFacture($newIdFacture);
        }

        return $this;
    }
}
