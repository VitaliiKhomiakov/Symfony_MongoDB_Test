<?php

declare(strict_types=1);

namespace App\Dto\Model;

class User {

    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getUserId(): string
    {
        return $this->id;
    }
}
