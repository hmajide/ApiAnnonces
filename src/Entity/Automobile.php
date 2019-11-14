<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AutomobileRepository")
 * @ApiResource()
 */
class Automobile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"listAnnonceFull"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listAutomobileFull"})
     */
    private $typeCarburant;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"listAutomobileFull"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="automobiles")
     */
    private $automobiles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCarburant(): ?string
    {
        return $this->typeCarburant;
    }

    public function setTypeCarburant(string $typeCarburant): self
    {
        $this->typeCarburant = $typeCarburant;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAutomobiles(): ?Categories
    {
        return $this->automobiles;
    }

    public function setAutomobiles(?Categories $automobiles): self
    {
        $this->automobiles = $automobiles;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->type_carburant;
    }

    /**
     * @return Collection|User[]
     */
    public function getRelationUser(): Collection
    {
        return $this->relationUser;
    }

    public function addRelationUser(User $relationUser): self
    {
        if (!$this->relationUser->contains($relationUser)) {
            $this->relationUser[] = $relationUser;
            $relationUser->setAutomobile($this);
        }

        return $this;
    }

    public function removeRelationUser(User $relationUser): self
    {
        if ($this->relationUser->contains($relationUser)) {
            $this->relationUser->removeElement($relationUser);
            // set the owning side to null (unless already changed)
            if ($relationUser->getAutomobile() === $this) {
                $relationUser->setAutomobile(null);
            }
        }

        return $this;
    }
   
}
