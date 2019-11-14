<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 * @ApiResource()
 */
class Categories
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"listCategoriesFull"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listCategoriesFull"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="categories")
     */
    private $Relation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Automobile", mappedBy="automobiles")
     */
    private $automobiles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Immobilier", mappedBy="immobiliers")
     */
    private $immobiliers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Emploi", mappedBy="emplois")
     */
    private $emplois;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonce", inversedBy="categories")
     */
    private $annonce;


    public function __construct()
    {
        $this->Relation = new ArrayCollection();
        $this->automobiles = new ArrayCollection();
        $this->immobiliers = new ArrayCollection();
        $this->emplois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getRelation(): Collection
    {
        return $this->Relation;
    }

    public function addRelation(Annonce $relation): self
    {
        if (!$this->Relation->contains($relation)) {
            $this->Relation[] = $relation;
            $relation->setCategories($this);
        }

        return $this;
    }

    public function removeRelation(Annonce $relation): self
    {
        if ($this->Relation->contains($relation)) {
            $this->Relation->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getCategories() === $this) {
                $relation->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Automobile[]
     */
    public function getAutomobiles(): Collection
    {
        return $this->automobiles;
    }

    public function addAutomobile(Automobile $automobile): self
    {
        if (!$this->automobiles->contains($automobile)) {
            $this->automobiles[] = $automobile;
            $automobile->setAutomobiles($this);
        }

        return $this;
    }

    public function removeAutomobile(Automobile $automobile): self
    {
        if ($this->automobiles->contains($automobile)) {
            $this->automobiles->removeElement($automobile);
            // set the owning side to null (unless already changed)
            if ($automobile->getAutomobiles() === $this) {
                $automobile->setAutomobiles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Immobilier[]
     */
    public function getImmobiliers(): Collection
    {
        return $this->immobiliers;
    }

    public function addImmobilier(Immobilier $immobilier): self
    {
        if (!$this->immobiliers->contains($immobilier)) {
            $this->immobiliers[] = $immobilier;
            $immobilier->setImmobiliers($this);
        }

        return $this;
    }

    public function removeImmobilier(Immobilier $immobilier): self
    {
        if ($this->immobiliers->contains($immobilier)) {
            $this->immobiliers->removeElement($immobilier);
            // set the owning side to null (unless already changed)
            if ($immobilier->getImmobiliers() === $this) {
                $immobilier->setImmobiliers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Emploi[]
     */
    public function getEmplois(): Collection
    {
        return $this->emplois;
    }

    public function addEmplois(Emploi $emplois): self
    {
        if (!$this->emplois->contains($emplois)) {
            $this->emplois[] = $emplois;
            $emplois->setEmplois($this);
        }

        return $this;
    }

    public function removeEmplois(Emploi $emplois): self
    {
        if ($this->emplois->contains($emplois)) {
            $this->emplois->removeElement($emplois);
            // set the owning side to null (unless already changed)
            if ($emplois->getEmplois() === $this) {
                $emplois->setEmplois(null);
            }
        }

        return $this;
    }
     public function __toString()
    {
        return (string) $this->name;
    }

}
