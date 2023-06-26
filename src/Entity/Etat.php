<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'Etat', targetEntity: Contact::class)]
    private Collection $Etat_Id;

    public function __construct()
    {
        $this->Etat_Id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getEtatId(): Collection
    {
        return $this->Etat_Id;
    }

    public function addEtatId(Contact $etatId): static
    {
        if (!$this->Etat_Id->contains($etatId)) {
            $this->Etat_Id->add($etatId);
            $etatId->setEtat($this);
        }

        return $this;
    }

    public function removeEtatId(Contact $etatId): static
    {
        if ($this->Etat_Id->removeElement($etatId)) {
            // set the owning side to null (unless already changed)
            if ($etatId->getEtat() === $this) {
                $etatId->setEtat(null);
            }
        }

        return $this;
    }
}
