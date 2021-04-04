<?php
declare(strict_types=1);

namespace App\Application;

use App\Infrastructure\Rpc\MethodResolver;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController
{
    private MethodResolver $resolver;

    public function __construct(MethodResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function method(Request $request, string $methodName): JsonResponse
    {
        $query = $request->query->all();

        try {
            $body = $request->toArray();
        } catch (JsonException $e) {
            $body = [];
        }

        $params = array_merge($query, $body);

        $methodBindName = strtolower(preg_replace('/[A-Z]/', '_\\0', $methodName));

        $result = $this->resolver->resolve($methodBindName, $params);

        return JsonResponse::fromJsonString($result);
    }
}
