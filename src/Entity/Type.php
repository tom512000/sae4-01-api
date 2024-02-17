<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Link;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource (operations: [
    new Get(
        uriTemplate: '/Type/{id}',
        normalizationContext: ['groups' => ['Type_read','Type_detail']],
    ),
    new Delete(
        uriTemplate: '/Type/{id}',
        normalizationContext: ['groups' => ['Type_read', 'Type_detail']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new Patch(
        uriTemplate: '/Type/{id}',
        normalizationContext: ['groups' => 'Type_detail', 'Type_read'],
        denormalizationContext: ['groups' => ['Type_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new GetCollection(
        uriTemplate: '/Type/{id}/Offre',
        uriVariables: ['id' => new Link(
            fromProperty: 'Type',
            fromClass: Offre::class
        )],
        normalizationContext: ['groups' => ['Type_read', 'Offre-Type_read']]
    ),
    new Post(
        uriTemplate: '/Type',
        normalizationContext: ['groups' => 'Type_read', 'Type_detail'],
        denormalizationContext: ['groups' => ['Type_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
],
)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Type_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Type_read', 'Type_write'])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'Type', targetEntity: Offre::class)]
    #[Groups(['Offre-Type_read'])]
    private Collection $offres;

    /**
     * Constructeur de la classe Type.
     */
    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Obtient l'ID du Type.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le libellé du Type.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé du Type.
     *
     * @return $this
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Obtient la collection des Offres liées à ce Type.
     *
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    /**
     * Ajoute une relation Offre à ce Type.
     *
     * @return $this
     */
    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setType($this);
        }

        return $this;
    }

    /**
     * Supprime une relation Offre de ce Type.
     *
     * @return $this
     */
    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getType() === $this) {
                $offre->setType(null);
            }
        }

        return $this;
    }
}
