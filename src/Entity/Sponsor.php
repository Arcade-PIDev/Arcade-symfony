<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Nom Sponsor ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $NomSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Positive(message:"Num Tel ne peut pas etre négatif")]
    #[Assert\NotBlank(message:"Num Tel ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $NumTelSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message:"Adresse email invalide")]
    #[Assert\NotBlank(message:"Email ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $EmailSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Domaine Sponsor ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $DomaineSponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Adresse Sponsor ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $AdresseSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Logo Sponsor ne doit pas etre vide")]
    #[Groups("list")]
    private ?string $logoSponsor = null;

    #[ORM\Column]
    #[Assert\Positive(message:"Montant ne peut pas etre négatif")]
    #[Assert\NotBlank(message:"Montant Sponsoring ne doit pas etre vide")]
    #[Groups("list")]
    private ?float $MontantSponsoring = null;

    #[ORM\ManyToOne(inversedBy: 'SponsorFK')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("list")]
    private ?Evenement $IDEventsFK = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

   
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }


  
}
