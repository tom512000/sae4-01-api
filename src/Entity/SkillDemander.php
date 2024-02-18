<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\SkillDemanderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SkillDemanderRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            normalizationContext: ['groups' => 'SkillDemander_read'],
            denormalizationContext: ['groups' => ['SkillDemander_write']],
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Delete(
            uriTemplate: '/SkillDemander/{id}',
            security: 'object.getUser() == user'
        ),
    ]
)]
#[UniqueEntity('skill', 'offre')]
class SkillDemander
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'skillDemanders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['SkillDemander_read','SkillDemander_write'])]
    private ?Skill $skill = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'skillDemanders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['SkillDemander_read','SkillDemander_write'])]
    private ?Offre $offre = null;

    /**
     * Obtient la compétence associée à la demande de compétence.
     */
    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    /**
     * Définit la compétence associée à la demande de compétence.
     *
     * @param Skill|null $skill la compétence à définir
     *
     * @return skillDemander L'instance actuelle de la demande de compétence
     */
    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Obtient l'offre associée à la demande de compétence.
     */
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    /**
     * Définit l'offre associée à la demande de compétence.
     *
     * @param offre|null $offre L'offre à définir
     *
     * @return skillDemander L'instance actuelle de la demande de compétence
     */
    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
