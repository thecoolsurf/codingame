<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $h1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Body::class, mappedBy="page", orphanRemoval=true)
     */
    private $bodies;

    public function __construct()
    {
        $this->bodies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function setH1(string $h1): self
    {
        $this->h1 = $h1;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Body[]
     */
    public function getBodies(): Collection
    {
        return $this->bodies;
    }

    public function addBody(Body $body): self
    {
        if (!$this->bodies->contains($body)) {
            $this->bodies[] = $body;
            $body->setPage($this);
        }

        return $this;
    }

    public function removeBody(Body $body): self
    {
        if ($this->bodies->contains($body)) {
            $this->bodies->removeElement($body);
            // set the owning side to null (unless already changed)
            if ($body->getPage() === $this) {
                $body->setPage(null);
            }
        }

        return $this;
    }
}
