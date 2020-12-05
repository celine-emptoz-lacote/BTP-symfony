<?php

namespace App\Entity;

use App\Entity\Chantiers;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChantiersRepository;

/**
 * @ORM\Entity(repositoryClass=ChantiersRepository::class)
 */
class Chantiers
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
    public $Adresse;

    /**
     * @ORM\Column(type="date")
     */
    public $Date_de_debut;

    /**
     * @ORM\OneToMany(targetEntity=Pointages::class, mappedBy="chantiers")
     */
    private $id_chantier;


    public function __construct()
    {
        $this->id_chantier = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->Date_de_debut;
    }

    public function setDateDeDebut(\DateTimeInterface $Date_de_debut): self
    {
        $this->Date_de_debut = $Date_de_debut;

        return $this;
    }

    /**
     * @return Collection|Pointages[]
     */
    public function getIdChantier(): Collection
    {
        return $this->id_chantier;
    }

    public function addIdChantier(Pointages $idChantier): self
    {
        if (!$this->id_chantier->contains($idChantier)) {
            $this->id_chantier[] = $idChantier;
            $idChantier->setChantiers($this);
        }

        return $this;
    }

    public function removeIdChantier(Pointages $idChantier): self
    {
        if ($this->id_chantier->removeElement($idChantier)) {
            // set the owning side to null (unless already changed)
            if ($idChantier->getChantiers() === $this) {
                $idChantier->setChantiers(null);
            }
        }

        return $this;
    }

    

    

  
}
