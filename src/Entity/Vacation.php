<?php

namespace App\Entity;

use App\Repository\VacationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacationRepository::class)]
class Vacation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateheuredebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateheurefin = null;

    #[ORM\ManyToOne(inversedBy: 'vacations')]
    private ?Atelier $atelier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateheuredebut(): ?\DateTimeInterface
    {
        return $this->dateheuredebut;
    }

    public function setDateheuredebut(\DateTimeInterface $dateheuredebut): static
    {
        $this->dateheuredebut = $dateheuredebut;

        return $this;
    }

    public function getDateheurefin(): ?\DateTimeInterface
    {
        return $this->dateheurefin;
    }

    public function setDateheurefin(\DateTimeInterface $dateheurefin): static
    {
        $this->dateheurefin = $dateheurefin;

        return $this;
    }

    public function getAtelier(): ?Atelier
    {
        return $this->atelier;
    }

    public function setAtelier(?Atelier $atelier): static
    {
        $this->atelier = $atelier;

        return $this;
    }
}
