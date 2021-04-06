<?php

namespace App\Infrastructure\Rpc\Interface;

interface MethodInterface
{
    public function exec(?array $params): mixed;
}
