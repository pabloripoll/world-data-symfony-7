<?php

namespace App\Entity;

use App\Repository\WorldCountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name:'world_countries')]
#[ORM\Entity(repositoryClass: WorldCountryRepository::class)]
class WorldCountry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function getId(): ?int { return $this->id; }

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $name = null;
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): static { $this->name = $name; return $this; }

    #[ORM\Column(nullable: true)]
    private ?array $content = null;
    public function getContent(): ?array { return $this->content; }
    public function setContent(?array $content): static { $this->content = $content; return $this; }

    #[ORM\CreatedAt]
    #[ORM\Column(name:'created_at')]
    private $created_at = null;
    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt(): self { $this->created_at = ''; return $this; }

    #[ORM\UpdatedAt]
    #[ORM\Column(name:'updated_at')]
    private $updated_at = null;
    public function getUpdatedAt() { return $this->updated_at; }
    public function setUpdatedAt(): self { $this->updated_at = ''; return $this; }

    /**
     * Hooks
     */

    #[ORM\PrePersist]
    public function setOnCreateEntity(): void {
        $this->created_at = \date("Y-m-d H:i:s");
        $this->setOnUpdateEntity();
    }

    #[ORM\PreUpdate]
    public function setOnUpdateEntity(): void {
        $this->updated_at = \date("Y-m-d H:i:s");
    }
}
