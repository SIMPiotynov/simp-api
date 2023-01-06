<?php

namespace App\Entity;

use App\Repository\AlarmRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
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
}
