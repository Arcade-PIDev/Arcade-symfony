<?php

namespace App\Entity;

use App\Repository\ParticipationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ParticipationsRepository::class)]
class Participations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom joueur is invalid")]
    private ?string $nomJoueur = null;
  
    #[ORM\Column]
    #[Assert\NotBlank(message:"NSC is invalid")]
    #[Assert\PositiveOrZero]
    #[Assert\Range(
        min: 2,
        max: 100,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    private ?int $nombreParticipants = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"niveau is invalid")]
    private ?string $niveau = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateParticipations = null;

    #[ORM\OneToMany(mappedBy: 'participations', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJoueur(): ?string
    {
        return $this->nomJoueur;
    }

    public function setNomJoueur(string $nomJoueur): self
    {
        $this->nomJoueur = $nomJoueur;

        return $this;
    }

    public function getNombreParticipants(): ?int
    {
        return $this->nombreParticipants;
    }

    public function setNombreParticipants(int $nombreParticipants): self
    {
        $this->nombreParticipants = $nombreParticipants;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getDateParticipations(): ?\DateTimeInterface
    {
        return $this->dateParticipations;
    }

    public function setDateParticipations(\DateTimeInterface $dateParticipations): self
    {
        $this->dateParticipations = $dateParticipations;

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
            $user->setParticipations($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getParticipations() === $this) {
                $user->setParticipations(null);
            }
        }

        return $this;
    }
}
