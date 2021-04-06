<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Serializer;

use App\Infrastructure\Rpc\Model\RpcResult;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RpcResultNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param \App\Infrastructure\Rpc\Model\RpcResult $object
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): mixed
    {
        $context[AbstractNormalizer::ATTRIBUTES] = $object->getAttributes();
        $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = $object->getIgnoredAttributes();

        return $this->normalizer->normalize($object->getResult(), $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof RpcResult;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
