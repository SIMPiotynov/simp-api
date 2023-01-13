<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Type;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["user"])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["user"])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user"])]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["user"])]
    private ?string $fingerprint = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity:History::class)]
    private ?Collection $histories = null;

    #[ORM\Column]
    #[Groups(["user"])]
    private ?bool $isAuthorized = null;


    public function __construct()
    {
        $this->histories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories[] = $history;
            $history->setUser($this);
        }

        return $this;
    }

    public function removeHistory(History $history): void
    {
        if ($this->histories->removeElement($history)) {
            if ($history->getUser() === $this) {
                $history->setUser(null);
            }
        }
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFingerprint(): ?string
    {
        return $this->fingerprint;
    }

    public function setFingerprint(string $fingerprint): self
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isIsAuthorized(): ?bool
    {
        return $this->isAuthorized;
    }

    public function setIsAuthorized(bool $isAuthorized): self
    {
        $this->isAuthorized = $isAuthorized;

        return $this;
    }
}
