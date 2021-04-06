<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc;

use App\Infrastructure\Rpc\Exception\RpcExceptionInterface;
use App\Infrastructure\Rpc\Model\RpcCall;
use App\Infrastructure\Rpc\Model\RpcCallResponse;
use App\Infrastructure\Rpc\Model\RpcRequest;
use App\Infrastructure\Rpc\Model\RpcResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class CallHandler
{
    private MethodResolver $resolver;
    private SerializerInterface $serializer;

    public function __construct(MethodResolver $resolver, SerializerInterface $serializer)
    {
        $this->resolver = $resolver;
        $this->serializer = $serializer;
    }

    public function handle(string $call): string
    {
        $rpcCall = $this->getCall($call);

        $rpcCallResponse = new RpcCallResponse($rpcCall->isBatch());
        foreach ($rpcCall->getRequestList() as $request) {
            $jsonrpc = $request instanceof RpcRequest ? $request->getJsonrpc() : '2.0';

            $rpcResponse = new RpcResponse($jsonrpc);

            try {
                if ($request instanceof \Exception) {
                    throw $request;
                }

                $rpcResponse->setId($request->getId());
                $rpcResponse->setIsNotification($request->isNotification());
                $rpcResponse->setResult($this->resolve($request));
            } catch (RpcExceptionInterface $exception) {
                $rpcResponse->setError($exception);
            }

            if (!$rpcResponse->isNotification()) {
                $rpcCallResponse->addResponse($rpcResponse);
            }
        }

        return $this->serializer->serialize($rpcCallResponse, 'json');
    }

    private function getCall(string $call): RpcCall
    {
        return $this->serializer->deserialize($call, RpcCall::class, 'json');
    }

    private function resolve(RpcRequest $request): mixed
    {
        return $this->resolver->resolve($request);
    }
}
