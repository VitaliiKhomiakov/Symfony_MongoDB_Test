<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\DtoInterface\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateUserRequest implements RequestDtoInterface
{
    private string $name;
    private string $email;

    public function __construct(Request $request)
    {
        $this->name = $request->get('name');
        $this->email = $request->get('email');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
