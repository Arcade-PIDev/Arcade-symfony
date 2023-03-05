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
    #[Assert\Regex(pattern:"/[a-zA-Z]/" , message:"Nom doit contenir des lettres seulement")]
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
    #[Assert\Regex(pattern:"/[a-zA-Z0-9,.!?]/" , message:"Description doit contenir des lettres et des chiffres seulement")]
    #[Assert\Length ([
        'min' => 5,
        'max' => 255,
        'minMessage' => 'min = 5 ',
        'maxMessage' => 'max = 255',
    ])]
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

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Wishlist::class, cascade:["remove"])]
    private Collection $wishlists;

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Review::class, cascade:["remove"])]
    private Collection $reviews;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
        $this->wishlists = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    /**
     * @return Collection<int, Wishlist>
     */
    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function addWishlist(Wishlist $wishlist): self
    {
        if (!$this->wishlists->contains($wishlist)) {
            $this->wishlists->add($wishlist);
            $wishlist->setProduits($this);
        }

        return $this;
    }

    public function removeWishlist(Wishlist $wishlist): self
    {
        if ($this->wishlists->removeElement($wishlist)) {
            // set the owning side to null (unless already changed)
            if ($wishlist->getProduits() === $this) {
                $wishlist->setProduits(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setProduits($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduits() === $this) {
                $review->setProduits(null);
            }
        }

        return $this;
    }
}
