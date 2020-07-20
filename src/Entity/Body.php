<?php

namespace App\Entity;

use App\Repository\BodyRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Page;

/**
 * @ORM\Entity(repositoryClass=BodyRepository::class)
 */
class Body
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
    private $h2;

    /**
     * @ORM\Column(type="text")
     */
    private $paragraphe;

    /**
     * @ORM\ManyToOne(targetEntity=page::class, inversedBy="bodies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;
    
    /* ********************************************************************** */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getH2(): ?string
    {
        return $this->h2;
    }

    public function setH2(string $h2): self
    {
        $this->h2 = $h2;

        return $this;
    }

    public function getParagraphe(): ?string
    {
        return $this->paragraphe;
    }

    public function setParagraphe(string $paragraphe): self
    {
        $this->paragraphe = $paragraphe;

        return $this;
    }

    public function getPage(): ?page
    {
        return $this->page;
    }

    public function setPage(?page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
    
}
