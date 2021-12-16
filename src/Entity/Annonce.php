<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_article;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    /**
     * @ORM\Column(type="float")
     */
    private $longueur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $largeur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hauteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="text")
     */
    private $histoire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_plancher;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_minimum;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_moyen;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_maximum;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img4;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="annonce")
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=Collec::class, inversedBy="annonces")
     */
    private $collec;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getTypeArticle(): ?string
    {
        return $this->type_article;
    }

    public function setTypeArticle(?string $type_article): self
    {
        $this->type_article = $type_article;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(?float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(?float $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }

    public function getPrixPlancher(): ?float
    {
        return $this->prix_plancher;
    }

    public function setPrixPlancher(?float $prix_plancher): self
    {
        $this->prix_plancher = $prix_plancher;

        return $this;
    }

    public function getPrixMinimum(): ?float
    {
        return $this->prix_minimum;
    }

    public function setPrixMinimum(?float $prix_minimum): self
    {
        $this->prix_minimum = $prix_minimum;

        return $this;
    }

    public function getPrixMoyen(): ?float
    {
        return $this->prix_moyen;
    }

    public function setPrixMoyen(?float $prix_moyen): self
    {
        $this->prix_moyen = $prix_moyen;

        return $this;
    }

    public function getPrixMaximum(): ?float
    {
        return $this->prix_maximum;
    }

    public function setPrixMaximum(?float $prix_maximum): self
    {
        $this->prix_maximum = $prix_maximum;

        return $this;
    }

    public function getImg1(): ?string
    {
        return $this->img1;
    }

    public function setImg1(string $img1): self
    {
        $this->img1 = $img1;

        return $this;
    }

    public function getImg2(): ?string
    {
        return $this->img2;
    }

    public function setImg2(?string $img2): self
    {
        $this->img2 = $img2;

        return $this;
    }

    public function getImg3(): ?string
    {
        return $this->img3;
    }

    public function setImg3(?string $img3): self
    {
        $this->img3 = $img3;

        return $this;
    }

    public function getImg4(): ?string
    {
        return $this->img4;
    }

    public function setImg4(?string $img4): self
    {
        $this->img4 = $img4;

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
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setAnnonce($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getAnnonce() === $this) {
                $note->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getCollec(): ?Collec
    {
        return $this->collec;
    }

    public function setCollec(?Collec $collec): self
    {
        $this->collec = $collec;

        return $this;
    }

}
