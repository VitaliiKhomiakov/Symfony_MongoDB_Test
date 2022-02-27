<?php
declare(strict_types=1);

namespace App\Provider;

use App\Document\Token;
use App\Document\User;
use App\Provider\ProviderInterface\TokenProviderInterface;

class TokenProvider extends BaseProvider implements TokenProviderInterface
{
    private Token $token;

    public function createToken(User $user): void
    {
        $token = new Token();
        $token->setUser($user)
          // dummy logic to create token
          ->setToken('user_token_' . $user->getId());

        $this->validate($token);

        $this->documentManager->persist($token);
        $this->documentManager->flush();

        $this->setToken($token);
    }

    public function setToken(Token $token): void
    {
        $this->token = $token;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

}
