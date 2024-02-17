<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\InscrireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Link;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InscrireRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            security: "is_granted('ROLE_USER')"
        ),
        new Delete(
            uriTemplate: '/inscriptions/{id}',
            security: 'object.getUser() == user'
        ),
        new GetCollection(
            uriTemplate: '/inscriptions',
            normalizationContext: ['groups' => 'inscrire_read'],
        ),
    ]
)]
#[UniqueEntity('Offre', 'User')]
class Inscrire
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    #[ORM\JoinColumn(name: 'idOffre', referencedColumnName: 'id')]
    #[Groups(['inscrire_read'])]
    private ?Offre $Offre = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'id')]
    #[Groups(['inscrire_read'])]
    private ?User $User = null;

    #[ORM\Column]
    #[Groups(['inscrire_read','User-inscrire_read'])]
    private ?int $Status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['inscrire_read','User-inscrire_read'])]
    private ?\DateTimeInterface $dateDemande = null;

    /**
     * Obtient l'offre à laquelle l'utilisateur est inscrit.
     */
    public function getOffre(): ?Offre
    {
        return $this->Offre;
    }

    /**
     * Définit l'offre à laquelle l'utilisateur est inscrit.
     *
     * @param offre|null $Offre L'offre à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setOffre(?Offre $Offre): static
    {
        $this->Offre = $Offre;

        return $this;
    }

    /**
     * Obtient l'utilisateur inscrit.
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    /**
     * Définit l'utilisateur inscrit.
     *
     * @param user|null $User L'utilisateur à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * Obtient le statut de l'inscription.
     */
    public function getStatus(): ?int
    {
        return $this->Status;
    }

    /**
     * Définit le statut de l'inscription.
     *
     * @param int $Status le statut à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setStatus(int $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * Obtient la date de la demande d'inscription.
     */
    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    /**
     * Définit la date de la demande d'inscription.
     *
     * @param \DateTimeInterface $dateDemande la date à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }
}
