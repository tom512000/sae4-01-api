<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
#[ApiResource (operations: [
    new Get(
        uriTemplate: '/Skill/{id}',
        normalizationContext: ['groups' => ['Skill_read','Skill_detail']],
    ),
    new Delete(
        uriTemplate: '/Skill/{id}',
        normalizationContext: ['groups' => ['Skill_read', 'Skill_detail']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new Patch(
        uriTemplate: '/Skill/{id}',
        normalizationContext: ['groups' => 'Skill_detail', 'Skill_read'],
        denormalizationContext: ['groups' => ['Skill_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new GetCollection(
        normalizationContext: ['groups' => ['Skill_read']]
    ),
    new Post(
        uriTemplate: '/Skill',
        normalizationContext: ['groups' => 'Skill_read', 'Skill_detail'],
        denormalizationContext: ['groups' => ['Skill_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
],
)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Skill_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['Skill_read',  'Skill_write'])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'skill', targetEntity: SkillDemander::class)]
    private Collection $skillDemanders;

    /**
     * Constructeur de la classe Skill.
     */
    public function __construct()
    {
        $this->skillDemanders = new ArrayCollection();
    }

    /**
     * Obtient l'identifiant de la compétence.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le libellé de la compétence.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé de la compétence.
     *
     * @param string $libelle le libellé de la compétence à définir
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Obtient la collection de demandes de compétences associée à la compétence.
     *
     * @return Collection<int, SkillDemander>
     */
    public function getSkillDemanders(): Collection
    {
        return $this->skillDemanders;
    }

    /**
     * Ajoute une demande de compétence à la collection associée à la compétence.
     *
     * @param SkillDemander $skillDemander la demande de compétence à ajouter
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function addSkillDemander(SkillDemander $skillDemander): static
    {
        if (!$this->skillDemanders->contains($skillDemander)) {
            $this->skillDemanders->add($skillDemander);
            $skillDemander->setSkill($this);
        }

        return $this;
    }

    /**
     * Supprime une demande de compétence de la collection associée à la compétence.
     *
     * @param SkillDemander $skillDemander la demande de compétence à supprimer
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function removeSkillDemander(SkillDemander $skillDemander): static
    {
        if ($this->skillDemanders->removeElement($skillDemander)) {
            if ($skillDemander->getSkill() === $this) {
                $skillDemander->setSkill(null);
            }
        }

        return $this;
    }
}
