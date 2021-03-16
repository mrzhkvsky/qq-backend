<?php
declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class BadRequestResponse extends JsonResponse
{
    public function __construct(string $message, array $errors = [])
    {
        $data = [
            'message' => $message
        ];

        if (!empty($errors)) {
            $data['errors'] = $errors;
        }

        parent::__construct($data, JsonResponse::HTTP_BAD_REQUEST);
    }
}
