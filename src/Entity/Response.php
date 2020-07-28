<?php

namespace App\Entity;

use App\Repository\Practice\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
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
     * @ORM\OneToOne(targetEntity=Question::class, cascade={"persist", "remove"})
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="responses")
     */
    private $user;

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

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

}
