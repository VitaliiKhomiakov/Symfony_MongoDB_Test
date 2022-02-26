<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\DtoInterface\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;

class TokenRequest implements RequestDtoInterface
{
    private string $token;

    public function __construct(Request $request)
    {
        $this->token = $request->headers->get('Authorization', '');
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
