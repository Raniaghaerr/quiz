<?php
// src/Entity/Reponse.php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $texte = null;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\Column(type: 'boolean')]
    private bool $correct = false;  // To indicate if it's the correct answer

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): static
    {
        $this->texte = $texte;
        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;
        return $this;
    }

    public function isCorrect(): bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): static
    {
        $this->correct = $correct;
        return $this;
    }
}


// namespace App\Entity;

// use App\Repository\ReponseRepository;
// use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: ReponseRepository::class)]
// class Reponse
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     private ?int $id = null;

//     #[ORM\Column]
//     private ?bool $etat = null;

//     #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'reponses')]
//     #[ORM\JoinColumn(nullable: false)]
//     private ?Question $question = null;

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getEtat(): ?bool
//     {
//         return $this->etat;
//     }

//     public function setEtat(bool $etat): static
//     {
//         $this->etat = $etat;
//         return $this;
//     }

//     public function getQuestion(): ?Question
//     {
//         return $this->question;
//     }

//     public function setQuestion(?Question $question): static
//     {
//         $this->question = $question;
//         return $this;
//     }
// }
