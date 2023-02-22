<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom Sponsor ne doit pas etre vide")]
    private ?string $NomSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Num Tel ne doit pas etre vide")]
    private ?string $NumTelSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message:"Adresse email invalide")]
    #[Assert\NotBlank(message:"Email ne doit pas etre vide")]
    private ?string $EmailSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Domaine Sponsor ne doit pas etre vide")]
    private ?string $DomaineSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Adresse Sponsor ne doit pas etre vide")]
    private ?string $AdresseSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Logo Sponsor ne doit pas etre vide")]
    private ?string $logoSponsor = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Montant ne peut pas etre négatif")]
    #[Assert\NotBlank(message:"Montant Sponsoring ne doit pas etre vide")]
    private ?float $MontantSponsoring = null;

    #[ORM\ManyToOne(inversedBy: 'SponsorFK')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $IDEventsFK = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsor(): ?string
    {
        return $this->NomSponsor;
    }

    public function setNomSponsor(string $NomSponsor): self
    {
        $this->NomSponsor = $NomSponsor;

        return $this;
    }

    public function getNumTelSponsor(): ?string
    {
        return $this->NumTelSponsor;
    }

    public function setNumTelSponsor(?string $NumTelSponsor): self
    {
        $this->NumTelSponsor = $NumTelSponsor;

        return $this;
    }

    public function getEmailSponsor(): ?string
    {
        return $this->EmailSponsor;
    }

    public function setEmailSponsor(string $EmailSponsor): self
    {
        $this->EmailSponsor = $EmailSponsor;

        return $this;
    }

    public function getDomaineSponsor(): ?string
    {
        return $this->DomaineSponsor;
    }

    public function setDomaineSponsor(?string $DomaineSponsor): self
    {
        $this->DomaineSponsor = $DomaineSponsor;

        return $this;
    }

    public function getAdresseSponsor(): ?string
    {
        return $this->AdresseSponsor;
    }

    public function setAdresseSponsor(?string $AdresseSponsor): self
    {
        $this->AdresseSponsor = $AdresseSponsor;

        return $this;
    }

    public function getLogoSponsor(): ?string
    {
        return $this->logoSponsor;
    }

    public function setLogoSponsor(string $logoSponsor): self
    {
        $this->logoSponsor = $logoSponsor;

        return $this;
    }

    public function getMontantSponsoring(): ?float
    {
        return $this->MontantSponsoring;
    }

    public function setMontantSponsoring(float $MontantSponsoring): self
    {
        $this->MontantSponsoring = $MontantSponsoring;

        return $this;
    }

    public function getIDEventsFK(): ?Evenement
    {
        return $this->IDEventsFK;
    }

    public function setIDEventsFK(?Evenement $IDEventsFK): self
    {
        $this->IDEventsFK = $IDEventsFK;

        return $this;
    }


  
}
