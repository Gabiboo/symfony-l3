<?php

namespace App\Entity;

use App\Repository\SouscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SouscriptionRepository::class)
 */
class Souscription
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
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="offer")
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="souscriptions")
     */
    private $user;


    public function __construct(Offer $offers, User $user)
    {
        $this->user = $user;
        $this->offers = $offers;
        $this->etat = "En attente";
        
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): ?Offer
    {
        return $this->offer;
    }

    public function setOffers(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function setSouscription(?User $souscription): self
    {
        $this->souscription = $souscription;

        return $this;
    }

    public function getSouscription(): ?User
    {
        return $this->souscription;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
