<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmploiRepository")
 * @ApiResource()
 */
class Emploi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"listEmploiFull"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"listEmploiFull"})
     */
    private $salaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @@Groups({"listEmploiFull"})
     */
    private $typeContrat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="emplois")
     */
    private $emplois;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getEmplois(): ?Categories
    {
        return $this->emplois;
    }

    public function setEmplois(?Categories $emplois): self
    {
        $this->emplois = $emplois;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->salaire ." ". $this->type_contrat;
    }

    /**
     * @return Collection|User[]
     */
    public function getEmploiUser(): Collection
    {
        return $this->emploiUser;
    }

    public function addEmploiUser(User $emploiUser): self
    {
        if (!$this->emploiUser->contains($emploiUser)) {
            $this->emploiUser[] = $emploiUser;
            $emploiUser->setEmploi($this);
        }

        return $this;
    }

    public function removeEmploiUser(User $emploiUser): self
    {
        if ($this->emploiUser->contains($emploiUser)) {
            $this->emploiUser->removeElement($emploiUser);
            // set the owning side to null (unless already changed)
            if ($emploiUser->getEmploi() === $this) {
                $emploiUser->setEmploi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRelationuser(): Collection
    {
        return $this->relationuser;
    }

    public function addRelationuser(User $relationuser): self
    {
        if (!$this->relationuser->contains($relationuser)) {
            $this->relationuser[] = $relationuser;
            $relationuser->setRelations($this);
        }

        return $this;
    }

    public function removeRelationuser(User $relationuser): self
    {
        if ($this->relationuser->contains($relationuser)) {
            $this->relationuser->removeElement($relationuser);
            // set the owning side to null (unless already changed)
            if ($relationuser->getRelations() === $this) {
                $relationuser->setRelations(null);
            }
        }

        return $this;
    }
}
