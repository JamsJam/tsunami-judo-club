<?php

namespace App\Entity;

use App\Repository\CommissairelvlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommissairelvlRepository::class)]
class Commissairelvl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $niveaux = null;

    /**
     * @var Collection<int, Licence>
     */
    #[ORM\OneToMany(targetEntity: Licence::class, mappedBy: 'commissairelvl')]
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
            $licence->setCommissairelvl($this);
        }

        return $this;
    }

    public function removeLicence(Licence $licence): static
    {
        if ($this->licences->removeElement($licence)) {
            // set the owning side to null (unless already changed)
            if ($licence->getCommissairelvl() === $this) {
                $licence->setCommissairelvl(null);
            }
        }

        return $this;
    }
}
