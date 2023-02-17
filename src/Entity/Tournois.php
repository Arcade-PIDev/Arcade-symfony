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

    private ?int $NBRparticipants = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Obligatoire")]
    private ?String $DureeTournois = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Obligatoire")]
    private ?\DateTimeInterface $DateDebutTournois = null;
   
    #[ORM\ManyToOne(inversedBy: 'tournois')]
    #[Assert\NotBlank(message:"Obligatoire")]

    private ?Jeux $Idjeuxfk = null;

    #[ORM\OneToMany(mappedBy: 'tournois', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getDureeTournois(): ?float
    {
        return $this->DureeTournois;
    }

    public function setDureeTournois(float $DureeTournois): self
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setTournois($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTournois() === $this) {
                $user->setTournois(null);
            }
        }

        return $this;
    }
}
