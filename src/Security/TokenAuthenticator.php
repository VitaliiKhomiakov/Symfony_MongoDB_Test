<?php

namespace App\Security;

use App\Document\User;
use App\Dto\Request\TokenRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public function getCredentials(Request $request): TokenRequest
    {
        return new TokenRequest($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        return $userProvider->getUserByToken($credentials->getToken());
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response();
    }

    public function supports(Request $request)
    {
        return true;
        // TODO: Implement supports() method.
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }

}
