<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ApiResource (order: ['nomEnt' => 'ASC'])]
#[ApiFilter(OrderFilter::class, properties: ['nomEnt'], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: ['nomEnt' => 'partial'])]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $nomEnt = null;

    #[ORM\Column(length: 128)]
    private ?string $adresse = null;

    #[ORM\Column(length: 128)]
    private ?string $mail = null;

    #[ORM\Column(length: 128)]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255)]
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
