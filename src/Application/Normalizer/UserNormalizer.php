<?php
declare(strict_types=1);

namespace App\Application\Normalizer;

use App\Domain\User\Entity\User;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements ContextAwareNormalizerInterface
{
    private ObjectNormalizer $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return $this->objectNormalizer->normalize($object, null, [
            ObjectNormalizer::IGNORED_ATTRIBUTES => [
                'password', 'salt', 'username', 'roles'
            ]
        ]);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof User;
    }
}
