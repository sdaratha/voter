<?php

namespace App\Entity;

use App\Repository\VoterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoterRepository::class)]
class Voter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'voters')]
    private ?Vote $voteID = null;

    #[ORM\OneToMany(mappedBy: 'voter', targetEntity: VoterAnswers::class, cascade: ['persist', 'remove'])]
    private Collection $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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

    public function getVoteID(): ?Vote
    {
        return $this->voteID;
    }

    public function setVoteID(?Vote $voteID): self
    {
        $this->voteID = $voteID;

        return $this;
    }

    /**
     * @return Collection<int, VoterAnswers>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(VoterAnswers $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setVoter($this);
        }

        return $this;
    }

    public function removeAnswer(VoterAnswers $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getVoter() === $this) {
                $answer->setVoter(null);
            }
        }

        return $this;
    }
}
