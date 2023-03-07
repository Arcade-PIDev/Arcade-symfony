<?php

namespace App\Entity;

use App\Repository\TournoisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TournoisRepository::class)]
class Tournois
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Obligatoire")]
    #[Assert\Positive(message:"le nombre doit etre positif")]
    #[Assert\Range(
        min: 2,
        max: 20,
        minMessage: 'Le nombre de participants doit au moins contenir 2 participants',
        maxMessage: 'Le nombre de participants ne doit pas dépasser 20 participants ',
    )]
    private ?int $NBRparticipants = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Obligatoire")]
    #[Assert\Positive(message:"la duree doit etre positive")]

    private ?String $DureeTournois = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Obligatoire")]
    private ?\DateTimeInterface $DateDebutTournois = null;
   
    #[ORM\ManyToOne(inversedBy: 'tournois')]
    #[Assert\NotBlank(message:"Obligatoire")]

    private ?Jeux $Idjeuxfk = null;

    #[ORM\ManyToOne(inversedBy: 'tournois')]
    private ?User $users = null;

   
    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNBRparticipants(): ?int
    {
        return $this->NBRparticipants;
    }

    public function setNBRparticipants(int $NBRparticipants): self
    {
        $this->NBRparticipants = $NBRparticipants;

        return $this;
    }

    public function getDureeTournois(): ?String
    {
        return $this->DureeTournois;
    }

    public function setDureeTournois(String $DureeTournois): self
    {
        $this->DureeTournois = $DureeTournois;

        return $this;
    }

    public function getDateDebutTournois(): ?\DateTimeInterface
    {
        return $this->DateDebutTournois;
    }

    public function setDateDebutTournois(\DateTimeInterface $DateDebutTournois): self
    {
        $this->DateDebutTournois = $DateDebutTournois;

        return $this;
    }

    public function getIdjeuxfk(): ?Jeux
    {
        return $this->Idjeuxfk;
    }

    public function setIdjeuxfk(?Jeux $Idjeuxfk): self
    {
        $this->Idjeuxfk = $Idjeuxfk;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    
}