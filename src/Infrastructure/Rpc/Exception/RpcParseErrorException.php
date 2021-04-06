<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;

class RpcParseErrorException extends RpcException
{
    #[Pure]
    public function __construct()
    {
        parent::__construct(self::PARSE_ERROR, 'Parse error');
    }
}
