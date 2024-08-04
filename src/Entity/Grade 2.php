<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $ceinture = null;

    #[ORM\Column(length: 10)]
    private ?string $grade = null;

    /**
     * @var Collection<int, Licence>
     */
    #[ORM\OneToMany(targetEntity: Licence::class, mappedBy: 'grade')]
    private Collection $licence;

    public function __construct()
    {
        $this->licence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCeinture(): ?string
    {
        return $this->ceinture;
    }

    public function setCeinture(string $ceinture): static
    {
        $this->ceinture = $ceinture;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

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
            $licence->setGrade($this);
        }

        return $this;
    }

    public function removeLicence(Licence $licence): static
    {
        if ($this->licence->removeElement($licence)) {
            // set the owning side to null (unless already changed)
            if ($licence->getGrade() === $this) {
                $licence->setGrade(null);
            }
        }

        return $this;
    }
}
