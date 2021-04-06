<?php
declare(strict_types=1);

namespace App\Application\Serializer;

use App\Domain\Shared\ValueObject\Id;
use Hashids\Hashids;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class IdNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private Hashids $hashids;

    public function __construct(Hashids $hashids)
    {
        $this->hashids = $hashids;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        return $this->hashids->encode($object->getValue());
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Id;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
