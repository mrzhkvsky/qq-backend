<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Serializer;

use App\Infrastructure\Rpc\Exception\RpcInvalidRequestException;
use App\Infrastructure\Rpc\Model\RpcCall;
use App\Infrastructure\Rpc\Model\RpcRequest;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RpcCallDenormalizer implements ContextAwareDenormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): RpcCall
    {
        $isBatch = true;
        if (!array_key_exists(0, $data)) {
            $isBatch = false;
            $data = [$data];
        }

        $rpcCall = new RpcCall($isBatch);
        foreach ($data as $request) {
            if (!is_array($request) || !isset($request['jsonrpc'], $request['method'])) {
                $request = new RpcInvalidRequestException();
            } else {
                /** @var RpcRequest $request */
                $request = $this->normalizer->denormalize($request, RpcRequest::class, $format);

                if (is_null($request->getId())) {
                    $request->setIsNotification(true);
                }
            }

            $rpcCall->addRequest($request);
        }

        return $rpcCall;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === RpcCall::class;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
