<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    public const STATUS_CHOICES = ['En cours', 'Terminée', 'Abandonnée'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $apprenant = null; 
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $formation = null; 


    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $dateInscription = null; 

    #[ORM\Column(length: 50)]
    #[Assert\Choice(
        choices: self::STATUS_CHOICES,
        message: "Le statut doit être 'En cours', 'Terminée' ou 'Abandonnée'."
    )]
    private ?string $statut = null; 
    #[ORM\Column]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: "La progression doit être entre {{ min }} et {{ max }}."
    )]
    private ?int $progressionPourcentage = null; 
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateFin = null; 

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: "La note doit être entre {{ min }} et {{ max }} (sur 20)."
    )]
    private ?string $note = null; 


    public function __construct()
    {
        // Initialisation des valeurs automatiques
        $this->dateInscription = new \DateTimeImmutable();
        $this->statut = self::STATUS_CHOICES[0]; 
        $this->progressionPourcentage = 0; 
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApprenant(): ?Utilisateur
    {
        return $this->apprenant;
    }

    public function setApprenant(?Utilisateur $apprenant): static
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }
    
    // --- GETTERS & SETTERS AJOUTÉS ---

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }
    // Pas de set pour dateInscription car elle est auto-générée

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProgressionPourcentage(): ?int
    {
        return $this->progressionPourcentage;
    }

    public function setProgressionPourcentage(int $progressionPourcentage): static
    {
        $this->progressionPourcentage = $progressionPourcentage;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeImmutable $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }
}