<?php

namespace App\Entity;

use App\Repository\NuiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NuiteRepository::class)]
class Nuite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datenuitee = null;

    #[ORM\ManyToOne(inversedBy: 'nuites')]
    private ?Inscription $inscription = null;

    #[ORM\ManyToOne(inversedBy: 'nuites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoriechambre $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatenuitee(): ?\DateTimeInterface
    {
        return $this->datenuitee;
    }

    public function setDatenuitee(\DateTimeInterface $datenuitee): static
    {
        $this->datenuitee = $datenuitee;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getCategorie(): ?Categoriechambre
    {
        return $this->categorie;
    }

    public function setCategorie(?Categoriechambre $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
