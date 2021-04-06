<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Serializer;

use App\Infrastructure\Rpc\Model\RpcResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RpcResponseNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param \App\Infrastructure\Rpc\Model\RpcResponse $object
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): mixed
    {
        if ($object->isNotification()) {
            return null;
        }

        $context = [
            AbstractNormalizer::ATTRIBUTES => ['jsonrpc', 'id']
        ];

        if (!is_null($object->getError())) {
            $context[AbstractNormalizer::ATTRIBUTES][] = 'error';
        } else {
            $context[AbstractNormalizer::ATTRIBUTES][] = 'result';
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof RpcResponse;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
