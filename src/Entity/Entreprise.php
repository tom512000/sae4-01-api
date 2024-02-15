<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ApiResource (operations: [
    new Get(
        uriTemplate: '/entreprise/{id}',
        security: "is_granted('ROLE_USER')"
    ),
    new Delete(
        uriTemplate: '/entreprise/{id}',
        normalizationContext: ['groups' => ['Entreprise_read', 'Entreprise_detail']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new Patch(
        uriTemplate: '/entreprise/{id}',
        normalizationContext: ['groups' => 'Entreprise_detail', 'Entreprise_read'],
        denormalizationContext: ['groups' => ['Entreprise_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
    new GetCollection(
        uriTemplate: '/entreprise',
        normalizationContext: ['groups' => 'Entreprise_read'],
    ),
    new Post(
        uriTemplate: '/entreprise',
        normalizationContext: ['groups' => 'Entreprise_read', 'Entreprise_detail'],
        denormalizationContext: ['groups' => ['Entreprise_write']],
        security: "is_granted('ROLE_ADMIN')"
    ),
],
    order: ['nomEnt' => 'ASC'])]
#[ApiFilter(OrderFilter::class, properties: ['nomEnt'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['nomEnt' => 'partial'])]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['User-inscrire_read', 'Entreprise_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Entreprise_read','Entreprise_detail','Entreprise_write'])]
    private ?string $nomEnt = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Entreprise_read','Entreprise_detail','Entreprise_write'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Entreprise_detail','Entreprise_write'])]
    private ?string $mail = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Entreprise_detail','Entreprise_write'])]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Entreprise_read','Entreprise_detail','Entreprise_write'])]
    private ?string $logo = null;

    /**
     * Obtient l'identifiant unique de l'entreprise.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le nom de l'entreprise.
     */
    public function getNomEnt(): ?string
    {
        return $this->nomEnt;
    }

    /**
     * Définit le nom de l'entreprise.
     *
     * @param string $nomEnt le nom de l'entreprise
     *
     * @return entreprise L'instance actuelle de l'entreprise
     */
    public function setNomEnt(string $nomEnt): static
    {
        $this->nomEnt = $nomEnt;

        return $this;
    }

    /**
     * Obtient l'adresse de l'entreprise.
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * Définit l'adresse de l'entreprise.
     *
     * @param string $adresse L'adresse de l'entreprise
     *
     * @return entreprise L'instance actuelle de l'entreprise
     */
    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Obtient le site web de l'entreprise.
     */
    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    /**
     * Définit le site web de l'entreprise.
     *
     * @param string $siteWeb le site web de l'entreprise
     *
     * @return entreprise L'instance actuelle de l'entreprise
     */
    public function setSiteWeb(string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Obtient l'adresse e-mail de l'entreprise.
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Définit l'adresse e-mail de l'entreprise.
     *
     * @param string $mail L'adresse e-mail de l'entreprise
     *
     * @return entreprise L'instance actuelle de l'entreprise
     */
    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Obtient le chemin du logo de l'entreprise.
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * Définit le chemin du logo de l'entreprise.
     *
     * @param string $logo le chemin du logo de l'entreprise
     *
     * @return entreprise L'instance actuelle de l'entreprise
     */
    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
