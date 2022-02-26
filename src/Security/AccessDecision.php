<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class AccessDecision implements AccessDecisionManagerInterface
{
    public function decide(TokenInterface $token, array $attributes, $object = null): bool
    {
        return count(array_intersect($token->getRoleNames(), $attributes)) > 0;
    }
}
