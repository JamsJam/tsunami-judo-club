<?php

namespace App\Entity;

use App\Repository\ArbitrelvlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArbitrelvlRepository::class)]
class Arbitrelvl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $niveaux = null;

    /**
     * @var Collection<int, Licence>
     */
    #[ORM\OneToMany(targetEntity: Licence::class, mappedBy: 'arbitrelvl')]
    private Collection $licences;

    public function __construct()
    {
        $this->licences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveaux(): ?string
    {
        return $this->niveaux;
    }

    public function setNiveaux(string $niveaux): static
    {
        $this->niveaux = $niveaux;

        return $this;
    }

    /**
     * @return Collection<int, Licence>
     */
    public function getLicences(): Collection
    {
        return $this->licences;
    }

    public function addLicence(Licence $licence): static
    {
        if (!$this->licences->contains($licence)) {
            $this->licences->add($licence);
            $licence->setArbitrelvl($this);
        }

        return $this;
    }

    public function removeLicence(Licence $licence): static
    {
        if ($this->licences->removeElement($licence)) {
            // set the owning side to null (unless already changed)
            if ($licence->getArbitrelvl() === $this) {
                $licence->setArbitrelvl(null);
            }
        }

        return $this;
    }
}
