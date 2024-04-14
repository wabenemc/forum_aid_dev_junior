<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Psr\Log\NullLogger;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'Il y a deja un compte avec ce pseudo There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $update_at = NULL;
    /**
     * @var Collection<int, response>
     */
    #[ORM\OneToMany(targetEntity: response::class, mappedBy: 'user')]
    private Collection $relation;

    /**
     * @var Collection<int, vote>
     */
    #[ORM\OneToMany(targetEntity: vote::class, mappedBy: 'user')]
    private Collection $relation2;

    /**
     * @var Collection<int, thread>
     */
    #[ORM\OneToMany(targetEntity: thread::class, mappedBy: 'user')]
    private Collection $relation3;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
        $this->relation2 = new ArrayCollection();
        $this->relation3 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     * @return Collection<int, response>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(response $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setUser($this);
        }

        return $this;
    }

    public function removeRelation(response $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getUser() === $this) {
                $relation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, vote>
     */
    public function getRelation2(): Collection
    {
        return $this->relation2;
    }

    public function addRelation2(vote $relation2): static
    {
        if (!$this->relation2->contains($relation2)) {
            $this->relation2->add($relation2);
            $relation2->setUser($this);
        }

        return $this;
    }

    public function removeRelation2(vote $relation2): static
    {
        if ($this->relation2->removeElement($relation2)) {
            // set the owning side to null (unless already changed)
            if ($relation2->getUser() === $this) {
                $relation2->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, thread>
     */
    public function getRelation3(): Collection
    {
        return $this->relation3;
    }

    public function addRelation3(thread $relation3): static
    {
        if (!$this->relation3->contains($relation3)) {
            $this->relation3->add($relation3);
            $relation3->setUser($this);
        }

        return $this;
    }

    public function removeRelation3(thread $relation3): static
    {
        if ($this->relation3->removeElement($relation3)) {
            // set the owning side to null (unless already changed)
            if ($relation3->getUser() === $this) {
                $relation3->setUser(null);
            }
        }

        return $this;
    }
}
