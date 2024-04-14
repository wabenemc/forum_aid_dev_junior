<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $thread = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?Thread $threads = null;

    /**
     * @var Collection<int, vote>
     */
    #[ORM\OneToMany(targetEntity: vote::class, mappedBy: 'response')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getThread(): ?int
    {
        return $this->thread;
    }

    public function setThread(int $thread): static
    {
        $this->thread = $thread;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getThreads(): ?Thread
    {
        return $this->threads;
    }

    public function setThreads(?Thread $threads): static
    {
        $this->threads = $threads;

        return $this;
    }

    /**
     * @return Collection<int, vote>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(vote $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setResponse($this);
        }

        return $this;
    }

    public function removeRelation(vote $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getResponse() === $this) {
                $relation->setResponse(null);
            }
        }

        return $this;
    }
}
