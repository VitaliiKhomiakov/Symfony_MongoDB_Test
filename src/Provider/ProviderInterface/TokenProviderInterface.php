<?php
declare(strict_types=1);

namespace App\Provider\ProviderInterface;

use App\Document\Token;
use App\Document\User;

interface TokenProviderInterface
{
    public function createToken(User $user);
    public function setToken(Token $token);
    public function getToken(): Token;
}
