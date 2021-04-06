<?php
declare(strict_types=1);

namespace App\Application\Serializer;

use App\Domain\User\Entity\User;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array|string
    {
        $ignoredAttributes = ['password', 'roles', 'salt', 'username'];

        if (!isset($context[AbstractNormalizer::IGNORED_ATTRIBUTES]) || is_null($context[AbstractNormalizer::IGNORED_ATTRIBUTES])) {
            $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = $ignoredAttributes;
        } else {
            $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = array_merge($context[AbstractNormalizer::IGNORED_ATTRIBUTES], $ignoredAttributes);
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
