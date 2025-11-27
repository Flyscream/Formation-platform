<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    public const NIVEAUX_DIFFICULTE = ['Débutant', 'Intermédiaire', 'Avancé'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
        min: 10,
        max: 200,
        minMessage: "Le titre doit faire au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut excéder {{ limit }} caractères."
    )]
    private ?string $titre = null; 

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: "La durée en heures doit être d'au moins 1 heure."
    )]
    private ?int $dureeHeures = null; // Durée en heures 

    #[ORM\Column(length: 50)]
    #[Assert\Choice(
        choices: self::NIVEAUX_DIFFICULTE,
        message: "Le niveau de difficulté doit être 'Débutant', 'Intermédiaire' ou 'Avancé'."
    )]
    private ?string $niveauDifficulte = null; // Niveau de difficulté 
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: "Le prix doit être positif ou zéro."
    )]
    private ?string $prix = null; 
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $dateCreation = null; 

    #[ORM\Column]
    private ?bool $estPubliee = null; 
    #[ORM\Column(nullable: true)]
    private ?int $capaciteMax = null; 

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable(); // Date de création automatique
        $this->estPubliee = false; 
    }
    
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

    public function getDureeHeures(): ?int
    {
        return $this->dureeHeures;
    }

    public function setDureeHeures(int $dureeHeures): static
    {
        $this->dureeHeures = $dureeHeures;

        return $this;
    }

    public function getNiveauDifficulte(): ?string
    {
        return $this->niveauDifficulte;
    }

    public function setNiveauDifficulte(string $niveauDifficulte): static
    {
        $this->niveauDifficulte = $niveauDifficulte;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }
    

    public function isEstPubliee(): ?bool
    {
        return $this->estPubliee;
    }

    public function setEstPubliee(bool $estPubliee): static
    {
        $this->estPubliee = $estPubliee;

        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->capaciteMax;
    }

    public function setCapaciteMax(?int $capaciteMax): static
    {
        $this->capaciteMax = $capaciteMax;

        return $this;
    }
}