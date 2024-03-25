<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualiteRepository::class)]
class Qualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libellequalite = null;

    #[ORM\OneToMany(mappedBy: 'idqualite', targetEntity: Licencie::class)]
    private Collection $licencies;

    public function __construct()
    {
        $this->licencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellequalite(): ?string
    {
        return $this->libellequalite;
    }

    public function setLibellequalite(string $libellequalite): static
    {
        $this->libellequalite = $libellequalite;

        return $this;
    }

    public function getLicencies(): ?Licencie
    {
        return $this->licencies;
    }

    public function setLicencies(?Licencie $licencies): static
    {
        $this->licencies = $licencies;

        return $this;
    }

    public function addLicency(Licencie $licency): static
    {
        if (!$this->licencies->contains($licency)) {
            $this->licencies->add($licency);
            $licency->setIdqualite($this);
        }

        return $this;
    }

    public function removeLicency(Licencie $licency): static
    {
        if ($this->licencies->removeElement($licency)) {
            // set the owning side to null (unless already changed)
            if ($licency->getIdqualite() === $this) {
                $licency->setIdqualite(null);
            }
        }

        return $this;
    }
}
