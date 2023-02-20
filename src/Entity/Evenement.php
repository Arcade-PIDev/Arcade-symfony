<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Lieu Evenement ne doit pas etre vide")]
    private ?string $lieu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Date Debut ne doit pas etre vide")]
    private ?\DateTimeInterface $DateDebutE = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Date Fin ne doit pas etre vide")]
    private ?\DateTimeInterface $DateFinE = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Affiche ne doit pas etre vide")]
    private ?string $AfficheE = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Prix Ticket ne peut pas etre négatif")]
    #[Assert\NotBlank(message:"Prix Ticket ne doit pas etre vide")]
    private ?float $PrixTicket = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Nombre de Places ne peut pas etre négatif")]
    #[Assert\NotBlank(message:"Nombre de Places ne doit pas etre vide")]
    private ?int $nbrPlaces = null;

    #[ORM\Column(length: 2000, nullable: true)]
    #[Assert\NotBlank(message:"Description ne doit pas etre vide")]
    private ?string $DescriptionEvent = null;

    #[ORM\OneToMany(mappedBy: 'IDEventsFK', targetEntity: Sponsor::class, orphanRemoval: true)]
    private Collection $SponsorFK;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom Evenement ne doit pas etre vide")]
    private ?string $NomEvent = null;

    #[ORM\OneToMany(mappedBy: 'pEventFK', targetEntity: ParticipationEvenement::class, orphanRemoval: true)]
    private Collection $participationEvenements;

    public function __construct()
    {
        $this->SponsorFK = new ArrayCollection();
        $this->participationEvenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateDebutE(): ?\DateTimeInterface
    {
        return $this->DateDebutE;
    }

    public function setDateDebutE(\DateTimeInterface $DateDebutE): self
    {
        $this->DateDebutE = $DateDebutE;

        return $this;
    }

    public function getDateFinE(): ?\DateTimeInterface
    {
        return $this->DateFinE;
    }

    public function setDateFinE(\DateTimeInterface $DateFinE): self
    {
        $this->DateFinE = $DateFinE;

        return $this;
    }

    public function getAfficheE(): ?string
    {
        return $this->AfficheE;
    }

    public function setAfficheE(?string $AfficheE): self
    {
        $this->AfficheE = $AfficheE;

        return $this;
    }

    public function getPrixTicket(): ?float
    {
        return $this->PrixTicket;
    }

    public function setPrixTicket(float $PrixTicket): self
    {
        $this->PrixTicket = $PrixTicket;

        return $this;
    }

    public function getNbrPlaces(): ?int
    {
        return $this->nbrPlaces;
    }

    public function setNbrPlaces(int $nbrPlaces): self
    {
        $this->nbrPlaces = $nbrPlaces;

        return $this;
    }

    public function getDescriptionEvent(): ?string
    {
        return $this->DescriptionEvent;
    }

    public function setDescriptionEvent(?string $DescriptionEvent): self
    {
        $this->DescriptionEvent = $DescriptionEvent;

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsorFK(): Collection
    {
        return $this->SponsorFK;
    }

    public function addSponsorFK(Sponsor $sponsorFK): self
    {
        if (!$this->SponsorFK->contains($sponsorFK)) {
            $this->SponsorFK->add($sponsorFK);
            $sponsorFK->setIDEventsFK($this);
        }

        return $this;
    }

    public function removeSponsorFK(Sponsor $sponsorFK): self
    {
        if ($this->SponsorFK->removeElement($sponsorFK)) {
            // set the owning side to null (unless already changed)
            if ($sponsorFK->getIDEventsFK() === $this) {
                $sponsorFK->setIDEventsFK(null);
            }
        }

        return $this;
    }

    public function getNomEvent(): ?string
    {
        return $this->NomEvent;
    }

    public function setNomEvent(string $NomEvent): self
    {
        $this->NomEvent = $NomEvent;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @return Collection<int, ParticipationEvenement>
     */
    public function getParticipationEvenements(): Collection
    {
        return $this->participationEvenements;
    }

    public function addParticipationEvenement(ParticipationEvenement $participationEvenement): self
    {
        if (!$this->participationEvenements->contains($participationEvenement)) {
            $this->participationEvenements->add($participationEvenement);
            $participationEvenement->setPEventFK($this);
        }

        return $this;
    }

    public function removeParticipationEvenement(ParticipationEvenement $participationEvenement): self
    {
        if ($this->participationEvenements->removeElement($participationEvenement)) {
            // set the owning side to null (unless already changed)
            if ($participationEvenement->getPEventFK() === $this) {
                $participationEvenement->setPEventFK(null);
            }
        }

        return $this;
    }
}
