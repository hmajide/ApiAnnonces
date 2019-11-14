<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImmobilierRepository")
 * @ApiResource()
 */
class Immobilier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"listImmobilierFull"})
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Groups({"listImmobilierFull"})
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"listImmobilierFull"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="immobiliers")
     */
    private $immobiliers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

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

    public function getImmobiliers(): ?Categories
    {
        return $this->immobiliers;
    }

    public function setImmobiliers(?Categories $immobiliers): self
    {
        $this->immobiliers = $immobiliers;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->price ." ". $this->surface;
    }
}
