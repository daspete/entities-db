<?php

namespace App\Entity;

use App\Repository\EnemyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EnemyRepository::class)]
class Enemy
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(enumType: EnemyType::class)]
    private ?EnemyType $type = null;

    #[ORM\Column]
    private ?int $energy = null;

    #[ORM\Column]
    private ?int $damage = null;

    #[ORM\Column]
    private ?float $fireRate = null;

    #[ORM\Column]
    private ?float $speed = null;

    #[ORM\Column(length: 50)]
    private ?string $visual = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?EnemyType
    {
        return $this->type;
    }

    public function setType(EnemyType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(int $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): static
    {
        $this->damage = $damage;

        return $this;
    }

    public function getFireRate(): ?float
    {
        return $this->fireRate;
    }

    public function setFireRate(float $fireRate): static
    {
        $this->fireRate = $fireRate;

        return $this;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(float $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getVisual(): ?string
    {
        return $this->visual;
    }

    public function setVisual(string $visual): static
    {
        $this->visual = $visual;

        return $this;
    }
}
