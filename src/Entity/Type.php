<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Licence>
     */
    #[ORM\OneToMany(targetEntity: Licence::class, mappedBy: 'type')]
    private Collection $licence;

    public function __construct()
    {
        $this->licence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Licence>
     */
    public function getLicence(): Collection
    {
        return $this->licence;
    }

    public function addLicence(Licence $licence): static
    {
        if (!$this->licence->contains($licence)) {
            $this->licence->add($licence);
            $licence->setType($this);
        }

        return $this;
    }

    public function removeLicence(Licence $licence): static
    {
        if ($this->licence->removeElement($licence)) {
            // set the owning side to null (unless already changed)
            if ($licence->getType() === $this) {
                $licence->setType(null);
            }
        }

        return $this;
    }
}
