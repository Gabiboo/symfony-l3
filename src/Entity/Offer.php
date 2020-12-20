<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use App\Entity\Souscription;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $intro;

    /**
     * @ORM\Column(type="text")
     */
    private $offre;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Souscription::class, mappedBy="offer")
     * @ORM\JoinColumn(nullable=false)
     */ 
    private $souscription;

    public function __construct()
    {
        $this->souscription = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getOffre(): ?string
    {
        return $this->offre;
    }

    public function setOffre(string $offre): self
    {
        $this->offre = $offre;

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

    /**
     * @return Collection|Souscription[]
     */
    public function getSouscription(): Collection
    {
        return $this->souscription;
    }
    
    public function addSouscription(Souscription $souscription): self
    {
        if (!$this->souscription->contains($souscription)) {
            $this->souscription[] = $souscription;
            $souscription->setOffers($this);
        }
        return $this;
    }

}
