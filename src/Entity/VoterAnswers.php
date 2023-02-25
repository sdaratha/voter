<?php

namespace App\Entity;

use App\Repository\VoterAnswersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoterAnswersRepository::class)]
class VoterAnswers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $decision = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Voter $voter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecision(): ?int
    {
        return $this->decision;
    }

    public function setDecision(int $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    public function getVoter(): ?Voter
    {
        return $this->voter;
    }

    public function setVoter(?Voter $voter): self
    {
        $this->voter = $voter;

        return $this;
    }
}
