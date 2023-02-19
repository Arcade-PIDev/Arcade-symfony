<?php

namespace App\Entity;

use App\Repository\SeancecoachingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeancecoachingRepository::class)]
class Seancecoaching
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebutSeance = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinSeance = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"prix is invalid")]
    private ?float $prixSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is invalid")]
    #[Assert\PositiveOrZero]
    private ?string $descriptionSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"image is invalid")]
    private ?string $imageSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"titre is invalid")]
    private ?string $titreSeance = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
