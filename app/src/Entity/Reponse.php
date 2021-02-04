<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("reponse:read")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups("reponse:read")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("reponse:read")
     */
    public $date_poste;

    /**
     * @ORM\ManyToOne(targetEntity=Sujet::class, inversedBy="reponses")
     */
    private $sujet;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reponses")
     * @Groups("reponse:read")
     */
    private $utilisateur;

    public function __construct()
    {
        $this->date_poste = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDatePoste(): ?\DateTimeInterface
    {
        return $this->date_poste;
    }

    public function setDatePoste(\DateTimeInterface $date_poste): self
    {
        $this->date_poste = $date_poste;

        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDatePosteToString()
    {
        return $this->date_poste->format("d-m-Y");
    }
}
