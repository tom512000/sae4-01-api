<?php

namespace App\Serialization\Denormalizer;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Context;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

/**
 * @method array getSupportedTypes(?string $format)
 */
class UserDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    const ALREADY_CALLED = 'USER_DENORMALIZER_ALREADY_CALLED';
    private UserPasswordHasherInterface $passwordHasher;
    private Security $security;

    use DenormalizerAwareTrait;

    private function __construct(UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $this->passwordHasher=$passwordHasher;
        $this->security=$security;
    }

    /**
     * @inheritDoc
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED]=true;
        if (isset($data['password'])){
            $data['password']=$this->passwordHasher->hashPassword($this->security->getUser(),$data['password']);
        }
        return $this->denormalizer->denormalize($data,$type,$format,$context);
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        if(!isset($context[self::ALREADY_CALLED]) and $type==User::class)
        {
            return true;
        }
        return false;
    }
}