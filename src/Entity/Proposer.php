<?php

namespace App\Entity;

use App\Repository\ProposerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProposerRepository::class)]
class Proposer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $tarifnuite = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?Categoriechambre $categoriechambre = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifnuite(): ?int
    {
        return $this->tarifnuite;
    }

    public function setTarifnuite(int $tarifnuite): static
    {
        $this->tarifnuite = $tarifnuite;

        return $this;
    }

    public function getCategoriechambre(): ?Categoriechambre
    {
        return $this->categoriechambre;
    }

    public function setCategoriechambre(?Categoriechambre $categoriechambre): static
    {
        $this->categoriechambre = $categoriechambre;

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
}
