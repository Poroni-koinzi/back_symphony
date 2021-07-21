<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvisRepository")
 */
class Avis
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
    private $idAvis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAvis;

    /**
     * @ORM\Column(type="text")
     */
    private $messageAvis;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAvis(): ?string
    {
        return $this->idAvis;
    }

    public function setIdAvis(string $idAvis): self
    {
        $this->idAvis = $idAvis;

        return $this;
    }

    public function getDateAvis(): ?\DateTimeInterface
    {
        return $this->dateAvis;
    }

    public function setDateAvis(\DateTimeInterface $dateAvis): self
    {
        $this->dateAvis = $dateAvis;

        return $this;
    }

    public function getMessageAvis(): ?string
    {
        return $this->messageAvis;
    }

    public function setMessageAvis(string $messageAvis): self
    {
        $this->messageAvis = $messageAvis;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }
}
