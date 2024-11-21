<?php
// src/Entity/Question.php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $enonce = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class, cascade: ['persist', 'remove'])]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnonce(): ?string
    {
        return $this->enonce;
    }

    public function setEnonce(string $enonce): static
    {
        $this->enonce = $enonce;
        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;
        return $this;
    }

    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }
        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }
        return $this;
    }
}


// <?php

// namespace App\Entity;

// use App\Repository\QuestionRepository;
// use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: QuestionRepository::class)]
// class Question
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     private ?int $id = null;

//     #[ORM\Column(length: 255)]
//     private ?string $enonce = null;

//     #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'questions')]
//     #[ORM\JoinColumn(nullable: false)]
//     private ?Quiz $quiz = null;

//     #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
//     private iterable $reponses;

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getEnonce(): ?string
//     {
//         return $this->enonce;
//     }

//     public function setEnonce(string $enonce): static
//     {
//         $this->enonce = $enonce;
//         return $this;
//     }

//     public function getQuiz(): ?Quiz
//     {
//         return $this->quiz;
//     }

//     public function setQuiz(?Quiz $quiz): static
//     {
//         $this->quiz = $quiz;
//         return $this;
//     }

//     public function getReponses(): iterable
//     {
//         return $this->reponses;
//     }

//     public function setReponses(iterable $reponses): static
//     {
//         $this->reponses = $reponses;
//         return $this;
//     }
// }

