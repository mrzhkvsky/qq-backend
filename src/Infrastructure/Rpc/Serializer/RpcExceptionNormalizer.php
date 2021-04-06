<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Serializer;

use App\Infrastructure\Rpc\Exception\RpcExceptionInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RpcExceptionNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param \App\Infrastructure\Rpc\Exception\RpcExceptionInterface $object
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): mixed
    {
        $error = [
            'code' => $object->getErrorCode(),
            'message' => $object->getErrorMessage()
        ];

        if (!empty($object->getErrorData())) {
            $error['data'] = $object->getErrorData();
        }

        return $this->normalizer->normalize((object) $error);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof RpcExceptionInterface;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
