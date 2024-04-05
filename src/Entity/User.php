<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\MeProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
#[ApiResource(
    operations:[
        new GetCollection(
            uriTemplate: 'users',
            normalizationContext: ['groups' => ['user_read']],
        ),
        new Get(
            uriTemplate: '/users/{id}',
            normalizationContext: ['groups' => ['user_read']],
            security: "object == user"
        ),
        new Delete(
            uriTemplate: '/users/{id}',
            security: "object == user",
        ),
        new Post(
            uriTemplate: '/usersInscription',
            normalizationContext: ['groups'=>['user_read']],
            denormalizationContext: ['groups'=>['user_write']],
        ),
        new Patch(normalizationContext: ['groups' => ['user_read','user_me']],
            denormalizationContext: ['groups' => ['user_write']],
            security: "object == user"),
        new Get(
            uriTemplate: '/me',
            openapiContext: [
                'summary' => 'Retrieves the connected user',
                'description' => 'Retrieves the connected user',
                'responses' => [
                    '200' => [
                        'description' => 'connected user resource',
                        'content' => [
                            'application/ld+json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/User.jsonld-User_me_User_read',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            normalizationContext: ['groups' => ['user_me']],
            provider: MeProvider::class
        ),
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user_read','user_me'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user_read','user_me','user_write'])]
    private string $firstName;

    #[ORM\Column(length: 180)]
    #[Groups(['user_read','user_me','user_write'])]
    private string $lastName;

    #[ORM\Column(length: 20)]
    #[Groups(['user_read','user_me','user_write'])]
    private string $phone;

    #[ORM\Column(type: 'date', length: 10)]
    #[Groups(['user_read','user_me','user_write'])]
    private \DateTimeInterface $dateNais;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user_me','user_write'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user_me','user_read'])]
    private array $roles = [];

    #[ORM\Column]
    #[Groups(['user_write'])]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Inscrire::class)]
    #[Groups('user_me')]
    private Collection $inscrires;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['user_read','user_me','user_write'])]
    private ?string $lettreMotiv = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['user_read','user_me','user_write'])]
    private ?string $cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user_read','user_me','user_write'])]
    private ?string $aboutMe = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['user_me','user_write'])]
    private $avatar = null;

    /**
     * Constructeur de la classe User.
     */
    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
    }

    /**
     * Obtient l'ID de l'utilisateur.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient l'adresse email de l'utilisateur.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Définit l'adresse email de l'utilisateur.
     *
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Obtient le prénom de l'utilisateur.
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Définit le prénom de l'utilisateur.
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Obtient le nom de famille de l'utilisateur.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Définit le nom de famille de l'utilisateur.
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Obtient le numéro de téléphone de l'utilisateur.
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Définit le numéro de téléphone de l'utilisateur.
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Obtient la date de naissance de l'utilisateur.
     */
    public function getDateNais(): \DateTimeInterface
    {
        return $this->dateNais;
    }

    /**
     * Obtient la date de naissance de l'utilisateur sous forme de chaîne formatée.
     */
    public function getDateNaisString(): string
    {
        return $this->dateNais->format('d F Y');
    }

    /**
     * Définit la date de naissance de l'utilisateur.
     */
    public function setDateNais(\DateTimeInterface $dateNais): void
    {
        $this->dateNais = $dateNais;
    }

    /**
     * Obtient un identifiant visuel représentant cet utilisateur.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Obtient les rôles de l'utilisateur.
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Définit les rôles de l'utilisateur.
     *
     * @return $this
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Obtient le mot de passe de l'utilisateur.
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     *
     * @return $this
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Obtient la lettre de motivation de l'utilisateur.
     */
    public function getLettreMotiv(): ?string
    {
        return $this->lettreMotiv;
    }

    /**
     * Définit la lettre de motivation de l'utilisateur.
     *
     * @return $this
     */
    public function setLettreMotiv(?string $lettreMotiv): self
    {
        $this->lettreMotiv = $lettreMotiv;

        return $this;
    }

    /**
     * Obtient le chemin vers le fichier du CV de l'utilisateur.
     */
    public function getCv(): ?string
    {
        return $this->cv;
    }

    /**
     * Définit le chemin vers le fichier du CV de l'utilisateur.
     *
     * @return $this
     */
    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Efface les informations de connexion sensibles.
     *
     * @see UserInterface
     *
     * Cette méthode est vide car aucune information sensible n'est stockée en permanence.
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * Obtient la collection des inscriptions de l'utilisateur.
     *
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    /**
     * Ajoute une inscription à la collection des inscriptions de l'utilisateur.
     *
     * @return $this
     */
    public function addInscrire(Inscrire $inscrire): static
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setUser($this);
        }

        return $this;
    }

    /**
     * Supprime une inscription de la collection des inscriptions de l'utilisateur.
     *
     * @return $this
     */
    public function removeInscrire(Inscrire $inscrire): static
    {
        if ($this->inscrires->removeElement($inscrire)) {
            if ($inscrire->getUser() === $this) {
                $inscrire->setUser(null);
            }
        }

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function setAboutMe(?string $aboutMe): static
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
