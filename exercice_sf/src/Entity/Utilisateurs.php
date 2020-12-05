<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 */
class Utilisateurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $Matricule;

    /**
     * @ORM\OneToMany(targetEntity=Pointages::class, mappedBy="utilisateurs")
     */
    public $id_utilisateur;

  



    public function __construct()
    {
        $this->id_utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    /**
     * @return Collection|Pointages[]
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->id_utilisateur;
    }

    public function addIdUtilisateur(Pointages $idUtilisateur): self
    {
        if (!$this->id_utilisateur->contains($idUtilisateur)) {
            $this->id_utilisateur[] = $idUtilisateur;
            $idUtilisateur->setUtilisateurs($this);
        }

        return $this;
    }

    public function removeIdUtilisateur(Pointages $idUtilisateur): self
    {
        if ($this->id_utilisateur->removeElement($idUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($idUtilisateur->getUtilisateurs() === $this) {
                $idUtilisateur->setUtilisateurs(null);
            }
        }

        return $this;
    }

   
    
}
