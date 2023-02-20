<?php

namespace App\Entity;

use App\Repository\ParticipationEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationEvenementRepository::class)]
class ParticipationEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NbrParticipantsE = null;

    #[ORM\ManyToOne(inversedBy: 'participationEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usersEventFk = null;

    #[ORM\ManyToOne(inversedBy: 'participationEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $pEventFK = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrParticipantsE(): ?int
    {
        return $this->NbrParticipantsE;
    }

    public function setNbrParticipantsE(int $NbrParticipantsE): self
    {
        $this->NbrParticipantsE = $NbrParticipantsE;

        return $this;
    }

    public function getUsersEventFk(): ?User
    {
        return $this->usersEventFk;
    }

    public function setUsersEventFk(?User $usersEventFk): self
    {
        $this->usersEventFk = $usersEventFk;

        return $this;
    }

    public function getPEventFK(): ?Evenement
    {
        return $this->pEventFK;
    }

    public function setPEventFK(?Evenement $pEventFK): self
    {
        $this->pEventFK = $pEventFK;

        return $this;
    }
}
