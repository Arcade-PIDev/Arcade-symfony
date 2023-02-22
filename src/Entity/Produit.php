<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"obligatoire")]
    #[Assert\Length ([
        'min' => 5,
        'max' => 255,
        'minMessage' => 'min = 5 ',
        'maxMessage' => 'max = 255',
    ])]
    #[Assert\Regex(pattern:"/[a-zA-Z]/" , message:"name must contain only letters")]
    private ?string $nomProduit = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"obligatoire")]
    #[Assert\Positive (message:"prix doit etre positive")]
    private ?int $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"obligatoire")]
    #[Assert\PositiveOrZero (message:"quantité doit etre positive ou egale a zero")]
    private ?int $quantiteStock = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"obligatoire")]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"obligatoire")]
    #[Assert\Length ([
        'min' => 5,
        'max' => 255,
        'minMessage' => 'min = 5 ',
        'maxMessage' => 'max = 255',
    ])]
    #[Assert\Regex(pattern:"/[a-zA-Z0-9,.!?]/" , message:"description must contain only letters")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]    
    private ?\DateTimeInterface $modificationDate = null;

    #[ORM\Column]
    private ?bool $isEnabled = null;

    #[ORM\ManyToOne(inversedBy: 'produits', targetEntity: Categorie::class)]
    #[Assert\NotBlank (message:"obligatoire")]
    private $categorie;

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Panier::class, cascade:["remove"])]
    private Collection $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): ?\DateTimeInterface
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?\DateTimeInterface $modificationDate): self
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduits($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduits() === $this) {
                $panier->setProduits(null);
            }
        }

        return $this;
    }
}
