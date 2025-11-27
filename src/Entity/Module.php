<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 
    
    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le titre du module est obligatoire.")]
    #[Assert\Length(max: 150, maxMessage: "Le titre ne peut excéder {{ limit }} caractères.")]
    private ?string $titre = null; 

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "La description du module est obligatoire.")]
    private ?string $description = null; 

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: "L'ordre doit être un nombre positif ou zéro.")]
    private ?int $ordre = null; 

    #[ORM\Column]
    #[Assert\GreaterThan(value: 0, message: "La durée estimée doit être supérieure à zéro.")]
    private ?int $dureeEstimee = null; 

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getDureeEstimee(): ?int
    {
        return $this->dureeEstimee;
    }

    public function setDureeEstimee(int $dureeEstimee): static
    {
        $this->dureeEstimee = $dureeEstimee;

        return $this;
    }
}