<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ResultNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $type = $object->getType();
        if ($type === RpcResult::SINGLE) {
            $result = $object->getData();
        } elseif ($type === RpcResult::COLLECTION) {
            $result = [
                'count' => $object->getCount(),
                'items' => $object->getData()
            ];
        } else {
            throw new \LogicException("Unknown type `$type`");
        }

        return $this->normalizer->normalize((object) ['result' => $result], $format, $context);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof RpcResult;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
