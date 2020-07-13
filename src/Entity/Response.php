<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Question;

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
     * @ORM\OneToOne(targetEntity=Question::class, mappedBy="response", cascade={"persist", "remove"})
     */
    private $question;
    
    /* ********************************************************************** */

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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        // set (or unset) the owning side of the relation if necessary
        $newAnswer = null === $question ? null : $this;
        if ($response->getAnswer() !== $newAnswer) {
            $response->setAnswer($newAnswer);
        }

        return $this;
    }
    
}
