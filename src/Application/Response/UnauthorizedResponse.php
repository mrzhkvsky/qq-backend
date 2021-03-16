<?php
declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class UnauthorizedResponse extends JsonResponse
{
    public function __construct(string $message)
    {
        $data = [
            'message' => $message
        ];

        parent::__construct($data, JsonResponse::HTTP_UNAUTHORIZED);
    }
}
