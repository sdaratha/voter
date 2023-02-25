<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $question = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\OneToMany(mappedBy: 'voteID', targetEntity: Answer::class, cascade: ['persist', 'remove'])]
    private Collection $answers;

    #[ORM\OneToMany(mappedBy: 'voteID', targetEntity: Voter::class, cascade: ['persist', 'remove'])]
    private Collection $voters;

    #[ORM\Column(length: 32)]
    private ?string $urlKey = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->voters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setVoteID($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getVoteID() === $this) {
                $answer->setVoteID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Voter>
     */
    public function getVoters(): Collection
    {
        return $this->voters;
    }

    public function addVoter(Voter $voter): self
    {
        if (!$this->voters->contains($voter)) {
            $this->voters->add($voter);
            $voter->setVoteID($this);
        }

        return $this;
    }

    public function removeVoter(Voter $voter): self
    {
        if ($this->voters->removeElement($voter)) {
            // set the owning side to null (unless already changed)
            if ($voter->getVoteID() === $this) {
                $voter->setVoteID(null);
            }
        }

        return $this;
    }

    public function getUrlKey(): ?string
    {
        return $this->urlKey;
    }

    public function setUrlKey(string $urlKey): self
    {
        $this->urlKey = $urlKey;

        return $this;
    }

    /**
     * @return Array<int, Answer>
     */
    public function getAnswerSums(): Array
    {
        $sums = [];
        foreach ($this->voters as $voter) {
            foreach($voter->getAnswers() as $answer) {
                dd($answer);
                if (!isset($sums[$answer->getId()])) {
                    $sums[$answer->getId()] = 0;
                }
                $sums[$answer->getId()]++;
            }
        }
        return $sums;
    }
}
