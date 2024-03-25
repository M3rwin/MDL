<?php

namespace App\Entity;

use App\Repository\CategoriechambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriechambreRepository::class)]
class Categoriechambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libellecategorie = null;

    #[ORM\OneToMany(mappedBy: 'categoriechambre', targetEntity: proposer::class)]
    private Collection $tarifs;

    public function __construct()
    {
        $this->tarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellecategorie(): ?string
    {
        return $this->libellecategorie;
    }

    public function setLibellecategorie(string $libellecategorie): static
    {
        $this->libellecategorie = $libellecategorie;

        return $this;
    }

    /**
     * @return Collection<int, proposer>
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Proposer $tarif): static
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs->add($tarif);
            $tarif->setCategoriechambre($this);
        }

        return $this;
    }

    public function removeTarif(Proposer $tarif): static
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getCategoriechambre() === $this) {
                $tarif->setCategoriechambre(null);
            }
        }

        return $this;
    }
}
