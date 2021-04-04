<?php

namespace App\Infrastructure\Rpc;

interface RpcMethod
{
    public function exec(array $params): RpcResult;
}
