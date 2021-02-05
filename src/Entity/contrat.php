<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 */
class Contrat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datedepart;

    /**
     * @ORM\Column(type="date")
     */
    private $dateretour;

  


    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voiture;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idclient;

  

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->datedepart;
    }

    public function setDatedepart(\DateTimeInterface $datedepart): self
    {
        $this->datedepart = $datedepart;

        return $this;
    }

    public function getDateretour(): ?\DateTimeInterface
    {
        return $this->dateretour;
    }

    public function setDateretour(\DateTimeInterface $dateretour): self
    {
        $this->dateretour = $dateretour;

        return $this;
    }

    public function getKmdepart(): ?int
    {
        return $this->kmdepart;
    }

    public function setKmdepart(int $kmdepart): self
    {
        $this->kmdepart = $kmdepart;

        return $this;
    }

    public function getKmretour(): ?int
    {
        return $this->kmretour;
    }

    public function setKmretour(int $kmretour): self
    {
        $this->kmretour = $kmretour;

        return $this;
    }

    public function getVoiture(): ?voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getIdclient(): ?client
    {
        return $this->idclient;
    }

    public function setIdclient(?client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    
}