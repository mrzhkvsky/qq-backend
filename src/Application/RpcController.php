<?php
declare(strict_types=1);

namespace App\Application;

use App\Infrastructure\Rpc\CallHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RpcController
{
    private CallHandler $callHandler;

    public function __construct(CallHandler $callHandler)
    {
        $this->callHandler = $callHandler;
    }

    public function call(Request $request): JsonResponse
    {
        $response = $this->callHandler->handle($request->getContent());

        return JsonResponse::fromJsonString($response);
    }
}
