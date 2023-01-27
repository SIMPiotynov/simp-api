<?php

namespace App\Entity;

use App\Repository\AlarmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AlarmRepository::class)]
class Alarm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["alarm"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["alarm"])]
    private ?string $alarm = null;

    #[ORM\Column(length: 255)]
    #[Groups(["alarm"])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'alarm', targetEntity: User::class, orphanRemoval: true)]
    #[Groups(["user_details"])]
    private Collection $users;

    #[ORM\Column]
    #[Groups(["alarm"])]
    private ?bool $isDefault = false;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlarm(): ?string
    {
        return $this->alarm;
    }

    public function setAlarm(string $alarm): self
    {
        $this->alarm = $alarm;

        return $this;
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAlarm($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAlarm() === $this) {
                $user->setAlarm(null);
            }
        }

        return $this;
    }

    public function isIsDefault(): ?bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
    }
}
