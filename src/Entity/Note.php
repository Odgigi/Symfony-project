<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note_insolite;

    /**
     * @ORM\Column(type="integer")
     */
    private $note_pratique;

    /**
     * @ORM\Column(type="integer")
     */
    private $note_style;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notes")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="notes")
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteInsolite(): ?int
    {
        return $this->note_insolite;
    }

    public function setNoteInsolite(int $note_insolite): self
    {
        $this->note_insolite = $note_insolite;

        return $this;
    }

    public function getNotePratique(): ?int
    {
        return $this->note_pratique;
    }

    public function setNotePratique(int $note_pratique): self
    {
        $this->note_pratique = $note_pratique;

        return $this;
    }

    public function getNoteStyle(): ?int
    {
        return $this->note_style;
    }

    public function setNoteStyle(int $note_style): self
    {
        $this->note_style = $note_style;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
