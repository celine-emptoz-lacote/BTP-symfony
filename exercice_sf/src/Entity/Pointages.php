<?php

namespace App\Entity;

use App\Repository\PointagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointagesRepository::class)
 */
class Pointages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    public $date_debut;

    /**
     * @ORM\ManyToOne(targetEntity=Chantiers::class, inversedBy="id_chantier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chantiers;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="id_utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    public $utilisateurs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getChantiers(): ?Chantiers
    {
        return $this->chantiers;
    }

    public function setChantiers(?Chantiers $chantiers): self
    {
        $this->chantiers = $chantiers;

        return $this;
    }

    public function getUtilisateurs(): ?Utilisateurs
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(?Utilisateurs $utilisateurs): self
    {
        $this->utilisateurs = $utilisateurs;

        return $this;
    }
}
