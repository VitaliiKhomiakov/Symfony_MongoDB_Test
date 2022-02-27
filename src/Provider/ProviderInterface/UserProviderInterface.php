<?php
declare(strict_types=1);

namespace App\Provider\ProviderInterface;

use App\Document\User;
use App\Dto\Request\CreateUserRequest;

interface UserProviderInterface
{
    public function createUser(CreateUserRequest $createUserRequest);
    public function setUser(User $user);
    public function getUser(): User;
}
