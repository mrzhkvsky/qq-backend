<?php
declare(strict_types=1);

namespace App\Application\Method\Account;

use App\Application\Method\AbstractMethod;
use App\Infrastructure\Rpc\Exception\RpcInvalidParamsException;
use App\Infrastructure\Rpc\RpcMethod;
use App\Infrastructure\Rpc\RpcResult;
use Symfony\Component\Validator\Constraints as Assert;

final class GetProfileInfoMethod extends AbstractMethod implements RpcMethod
{
    public function exec(array $data): RpcResult
    {
        $invalidParams = $this->validate($data, $this->rules());

        if (count($invalidParams) > 0) {
            throw new RpcInvalidParamsException($invalidParams);
        }

        return new RpcResult($this->getUser());
    }

    private function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'id' => new Assert\Positive()
        ]);
    }
}
