<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

final class UserFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;
    private \Transliterator $transliterer;

    /**
     * Constructeur de la factory.
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->passwordHasher = $passwordHasher;
        $this->transliterer = \Transliterator::create('Any-Lower; Latin-ASCII; Lower()');
    }

    protected function normalizeName(string $name): array|string|null
    {
        $name = str_replace('/[^a-z]+/', '-', $name);

        return $this->transliterer->transliterate($name);
    }

    /**
     * Définit les valeurs par défaut lors de la création d'un User.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        $firstName = self::faker()->firstName();
        $lastName = self::faker()->lastName();
        return [
            'dateNais' => self::faker()->dateTime,
            'email' => $this->normalizeName($firstName).'.'.$this->normalizeName($lastName).'@'.preg_replace('/[^A-Za-z0-9 ]/', '.', self::faker()->domainName()),
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => 'test',
            'phone' => self::faker()->phoneNumber(),
            'roles' => [],
            'status' => 1,
            'aboutMe' => self::faker()->realText(),
            'avatar' => "https://thispersondoesnotexist.com/"
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return UserFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe User
     */
    protected static function getClass(): string
    {
        return User::class;
    }
}
