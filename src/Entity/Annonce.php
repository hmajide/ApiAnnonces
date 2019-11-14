<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 * @ApiResource()
 * @UniqueEntity(
 *    fields={"name"},
 *     message="le nom existe déja {{ value }}, veuillez saisir un nom"
 * )
 */
class Annonce
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
     * @Groups({"listAnnonceFull"})
     * @ApiSubresource()
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     minMessage=" le nom doit contenir au moins {{ limit }} caracteres",
     *     maxMessage=" le nom contenir au plus {{ limit }} caracteres"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categories", mappedBy="annonce")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="relationuser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function __construct()
    {
        $this->categories = new ArrayCollection();

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
     * @return Collection|Categories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setAnnonce($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getAnnonce() === $this) {
                $category->setAnnonce(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string)  $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
