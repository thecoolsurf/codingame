<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Question() have One Category()
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinColumn(name="categories_id", referencedColumnName="id")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sort;

    /* ********************************************************************** */
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): ?category
    {
        return $this->categories;
    }

    public function setCategories(?category $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
