<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $answer;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, mappedBy="answer", cascade={"persist", "remove"})
     */
    private $response;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getResponse(): ?Question
    {
        return $this->response;
    }

    public function setResponse(?Question $response): self
    {
        $this->response = $response;

        // set (or unset) the owning side of the relation if necessary
        $newAnswer = null === $response ? null : $this;
        if ($response->getAnswer() !== $newAnswer) {
            $response->setAnswer($newAnswer);
        }

        return $this;
    }
}
