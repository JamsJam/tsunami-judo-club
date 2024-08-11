<?php

namespace App\Entity;

use App\Entity\Event;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LicenceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: LicenceRepository::class)]
class Licence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $renewedAt = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $beginAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $upgradedAt = null;

    #[ORM\ManyToOne(inversedBy: 'licence')]
    private ?Grade $grade = null;

    #[ORM\ManyToOne(inversedBy: 'licences')]
    private ?Arbitrelvl $arbitrelvl = null;



    /**
     * @var Collection<int, Certificates>
     */
    #[ORM\OneToMany(targetEntity: Certificates::class, mappedBy: 'licences')]
    private Collection $certificates;

    #[ORM\ManyToOne(inversedBy: 'licences')]
    private ?Commissairelvl $commissairelvl = null;

    #[ORM\OneToOne(mappedBy: 'licence', cascade: ['persist', 'remove'])]
    private ?Contacturgence $contacturgence = null;

    #[ORM\OneToOne(mappedBy: 'licence', cascade: ['persist', 'remove'])]
    private ?Adherent $adherent = null;

    /**
     * @var Collection<int, Groupe>
     */
    #[ORM\ManyToMany(targetEntity: Groupe::class, mappedBy: 'licence')]
    private Collection $groupes;

    #[ORM\ManyToOne(inversedBy: 'licence')]
    private ?Type $type = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'invite')]
    private Collection $inviteTo;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'licence')]
    private Collection $participations;

    public function __construct()
    {
        $this->certificates = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->inviteTo = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRenewedAt(): ?\DateTimeImmutable
    {
        return $this->renewedAt;
    }

    public function setRenewedAt(?\DateTimeImmutable $renewedAt): static
    {
        $this->renewedAt = $renewedAt;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeImmutable
    {
        return $this->beginAt;
    }

    public function setBeginAt(?\DateTimeImmutable $beginAt): static
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getUpgradedAt(): ?\DateTimeImmutable
    {
        return $this->upgradedAt;
    }

    public function setUpgradedAt(?\DateTimeImmutable $upgradedAt): static
    {
        $this->upgradedAt = $upgradedAt;

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getArbitrelvl(): ?Arbitrelvl
    {
        return $this->arbitrelvl;
    }

    public function setArbitrelvl(?Arbitrelvl $arbitrelvl): static
    {
        $this->arbitrelvl = $arbitrelvl;

        return $this;
    }


    /**
     * @return Collection<int, Certificates>
     */
    public function getCertificates(): ?Collection
    {
        return $this->certificates;
    }

    public function addCertificate(Certificates $certificate): static
    {
        if (!$this->certificates->contains($certificate)) {
            $this->certificates->add($certificate);
            $certificate->setLicences($this);
        }

        return $this;
    }

    public function removeCertificate(?Certificates $certificate): static
    {
        if ($this->certificates->removeElement($certificate)) {
            // set the owning side to null (unless already changed)
            if ($certificate->getLicences() === $this) {
                $certificate->setLicences(null);
            }
        }

        return $this;
    }

    public function getCommissairelvl(): ?Commissairelvl
    {
        return $this->commissairelvl;
    }

    public function setCommissairelvl(?Commissairelvl $commissairelvl): static
    {
        $this->commissairelvl = $commissairelvl;

        return $this;
    }

    public function getContacturgence(): ?Contacturgence
    {
        return $this->contacturgence;
    }

    public function setContacturgence(?Contacturgence $contacturgence): static
    {
        // unset the owning side of the relation if necessary
        if ($contacturgence === null && $this->contacturgence !== null) {
            $this->contacturgence->setLicence(null);
        }

        // set the owning side of the relation if necessary
        if ($contacturgence !== null && $contacturgence->getLicence() !== $this) {
            $contacturgence->setLicence($this);
        }

        $this->contacturgence = $contacturgence;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): static
    {
        // unset the owning side of the relation if necessary
        if ($adherent === null && $this->adherent !== null) {
            $this->adherent->setLicence(null);
        }

        // set the owning side of the relation if necessary
        if ($adherent !== null && $adherent->getLicence() !== $this) {
            $adherent->setLicence($this);
        }

        $this->adherent = $adherent;

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): static
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->addLicence($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): static
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeLicence($this);
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getInviteTo(): Collection
    {
        return $this->inviteTo;
    }

    public function addInviteTo(Event $inviteTo): static
    {
        if (!$this->inviteTo->contains($inviteTo)) {
            $this->inviteTo->add($inviteTo);
            $inviteTo->addInvite($this);
        }

        return $this;
    }

    public function removeInviteTo(Event $inviteTo): static
    {
        if ($this->inviteTo->removeElement($inviteTo)) {
            $inviteTo->removeInvite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setLicence($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getLicence() === $this) {
                $participation->setLicence(null);
            }
        }

        return $this;
    }
}
