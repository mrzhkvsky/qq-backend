<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc;

use App\Infrastructure\Rpc\Exception\RpcInvalidParamsException;
use App\Infrastructure\Rpc\Exception\RpcInvalidRequestException;
use App\Infrastructure\Rpc\Exception\RpcMethodNotFoundException;
use App\Infrastructure\Rpc\Interface\MethodWithValidatedParamsInterface;
use App\Infrastructure\Rpc\Model\RpcRequest;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MethodResolver
{
    private ContainerInterface $container;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(ContainerInterface $container, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->container = $container;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @throws \App\Infrastructure\Rpc\Exception\RpcMethodNotFoundException
     * @throws \App\Infrastructure\Rpc\Exception\RpcInvalidParamsException
     * @throws \App\Infrastructure\Rpc\Exception\RpcInvalidRequestException
     */
    public function resolve(RpcRequest $request): mixed
    {
        if (!$this->container->has($request->getMethod())) {
            throw new RpcMethodNotFoundException($request->getMethod());
        }

        /** @var \App\Infrastructure\Rpc\Interface\MethodInterface $method */
        $method = $this->container->get($request->getMethod());

        if ($method instanceof MethodWithValidatedParamsInterface) {
            if (is_null($request->getParams())) {
                throw new RpcInvalidRequestException();
            }

            $this->validate($request->getParams(), $method->getParamsConstraint());
        }

        return $method->exec($request->getParams());
    }

    /**
     * @throws \App\Infrastructure\Rpc\Exception\RpcInvalidParamsException
     */
    private function validate(array $params, Constraint $constraint): void
    {
        $violationList = $this->validator->validate($params, $constraint);
        if ($violationList->count() > 0) {
            throw new RpcInvalidParamsException($violationList);
        }
    }
}
