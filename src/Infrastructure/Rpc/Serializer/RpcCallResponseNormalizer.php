<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Serializer;

use App\Infrastructure\Rpc\Model\RpcCallResponse;
use App\Infrastructure\Rpc\Model\RpcResult;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class RpcCallResponseNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private RpcResponseNormalizer $normalizer;

    public function __construct(RpcResponseNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param \App\Infrastructure\Rpc\Model\RpcCallResponse $object
     *
     * @return null|\App\Infrastructure\Rpc\Model\RpcResult[]|\App\Infrastructure\Rpc\Model\RpcResult
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): null|array|RpcResult
    {
        $resultList = [];
        foreach ($object->getResponseList() as $rpcResponse) {
            $resultList[] = $this->normalizer->normalize($rpcResponse);
        }

        if (!$object->isBatch()) {
            return array_shift($resultList);
        }

        return $resultList;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof RpcCallResponse;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
