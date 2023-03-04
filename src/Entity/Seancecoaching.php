<?php

namespace App\Entity;

use App\Repository\SeancecoachingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeancecoachingRepository::class)]
class Seancecoaching
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date est invalide")]
    private ?\DateTimeInterface $dateDebutSeance = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date est invalide")]
    private ?\DateTimeInterface $dateFinSeance = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"prix est invalide")]
    #[Assert\Positive (message:"prix doit etre positive")]
    private ?float $prixSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description est invalide")]
    private ?string $descriptionSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"image est invalide")]
    private ?string $imageSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"titre est invalide")]
    #[Assert\Regex(pattern:"/[a-zA-Z]*/",message:"Le titre ne peut pas contenir des chiffres")]
    private ?string $titreSeance = null;

    #[ORM\OneToMany(mappedBy: 'idseancefk', targetEntity: Participations::class, cascade:["remove"])]
    #[MaxDepth(2)]
    private Collection $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
   
    public function __toString()
    {
        return(string) $this->getId();
    }
    public function getDateDebutSeance(): ?\DateTimeInterface
    {
        return $this->dateDebutSeance;
    }

    public function setDateDebutSeance(\DateTimeInterface $dateDebutSeance): self
    {
        $this->dateDebutSeance = $dateDebutSeance;

        return $this;
    }

    public function getDateFinSeance(): ?\DateTimeInterface
    {
        return $this->dateFinSeance;
    }

    public function setDateFinSeance(\DateTimeInterface $dateFinSeance): self
    {
        $this->dateFinSeance = $dateFinSeance;

        return $this;
    }

    public function getPrixSeance(): ?float
    {
        return $this->prixSeance;
    }

    public function setPrixSeance(float $prixSeance): self
    {
        $this->prixSeance = $prixSeance;

        return $this;
    }

    public function getDescriptionSeance(): ?string
    {
        return $this->descriptionSeance;
    }

    public function setDescriptionSeance(string $descriptionSeance): self
    {
        $this->descriptionSeance = $descriptionSeance;

        return $this;
    }

    public function getImageSeance(): ?string
    {
        return $this->imageSeance;
    }

    public function setImageSeance(string $imageSeance): self
    {
        $this->imageSeance = $imageSeance;

        return $this;
    }

    public function getTitreSeance(): ?string
    {
        return $this->titreSeance;
    }

    public function setTitreSeance(string $titreSeance): self
    {
        $this->titreSeance = $titreSeance;

        return $this;
    }

    /**
     * @return Collection<int, Participations>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participations $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setIdseancefk($this);
        }

        return $this;
    }

    public function removeParticipation(Participations $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getIdseancefk() === $this) {
                $participation->setIdseancefk(null);
            }
        }

        return $this;
    }
}
