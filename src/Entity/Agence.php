<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $telAgence;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresseVille;

    /**
     * @ORM\OneToMany(targetEntity=Voiture::class, mappedBy="idAgence")
     */
    private $voitures;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="idAgence")
     */
    private $Users;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
        $this->Users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTelAgence(): ?int
    {
        return $this->telAgence;
    }

    public function setTelAgence(int $telAgence): self
    {
        $this->telAgence = $telAgence;

        return $this;
    }

    public function getAdresseVille(): ?string
    {
        return $this->adresseVille;
    }

    public function setAdresseVille(string $adresseVille): self
    {
        $this->adresseVille = $adresseVille;

        return $this;
    }

    /**
     * @return Collection|Voiture[]
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): self
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures[] = $voiture;
            $voiture->setIdAgence($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): self
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getIdAgence() === $this) {
                $voiture->setIdAgence(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
            $user->setIdAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->Users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getIdAgence() === $this) {
                $user->setIdAgence(null);
            }
        }

        return $this;
    }
}

