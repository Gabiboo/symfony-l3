<?php

namespace App\Entity;

use App\Entity\Souscription;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocked;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $civilite;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * * @Assert\Regex("^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})^")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex("^(([0-8][0-9])|(9[0-5]))[0-9]{3}^")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex("^[12][0-9]{2}[0-1][0-9](2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}[0-9]{2}^")
     */
    private $numero_de_secu;

    /**
     * @ORM\OneToMany(targetEntity=Souscription::class, mappedBy="user")
     */
    private $souscriptions;

    public function __construct()
    {
        $this->souscriptions = new ArrayCollection();
        $this->roles[] = "ROLE_USER";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAgeuser(){
        $now = new \DateTime('now');
        $date = $this->date_de_naissance;
        $difference = $now->diff($date);

        return $difference->y;
    }
    
    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(?int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getNumeroDeSecu(): ?string
    {
        return $this->numero_de_secu;
    }

    public function setNumeroDeSecu(?string $numero_de_secu): self
    {
        $this->numero_de_secu = $numero_de_secu;

        return $this;
    }

    /**
     * @return Collection|Souscription[]
     */
    public function getSouscriptions(): Collection
    {
        return $this->souscriptions;
    }

    public function addSouscription(Souscription $souscription): self
    {
        if (!$this->souscriptions->contains($souscription)) {
            $this->souscriptions[] = $souscription;
            $souscription->setUser($this);
        }

        return $this;
    }

    public function removeSouscription(Souscription $souscription): self
    {
        if ($this->souscriptions->contains($souscription)) {
            $this->souscriptions->removeElement($souscription);
            // set the owning side to null (unless already changed)
            if ($souscription->getUser() === $this) {
                $souscription->setUser(null);
            }
        }

        return $this;
    }
}
