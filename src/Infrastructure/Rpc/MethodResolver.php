<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc;

use App\Infrastructure\Rpc\Exception\RpcMethodNotFoundException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MethodResolver
{
    private ContainerInterface $container;
    private SerializerInterface $serializer;

    public function __construct(ContainerInterface $container, SerializerInterface $serializer)
    {
        $this->container = $container;
        $this->serializer = $serializer;
    }

    /**
     * @throws \App\Infrastructure\Rpc\Exception\RpcMethodNotFoundException
     */
    public function resolve(string $methodName, array $params): string
    {
        if (!$this->container->has($methodName)) {
            throw new RpcMethodNotFoundException($methodName);
        }

        /** @var \App\Infrastructure\Rpc\RpcMethod $service */
        $service = $this->container->get($methodName);
        $result = $service->exec($params);

        return $this->serializer->serialize($result, 'json');
    }
}
