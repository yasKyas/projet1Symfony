<?php

namespace App\Entity;

use App\Repository\EmplacementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmplacementRepository::class)
 */
class Emplacement
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
    private $Nom;

    /**
     * @ORM\OneToOne(targetEntity=Voiture::class, inversedBy="emplacement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idvoiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getIdvoiture(): ?Voiture
    {
        return $this->idvoiture;
    }

    public function setIdvoiture(Voiture $idvoiture): self
    {
        $this->idvoiture = $idvoiture;

        return $this;
    }
}
