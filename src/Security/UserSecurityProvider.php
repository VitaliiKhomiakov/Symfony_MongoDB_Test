<?php

namespace App\Security;

use App\Document\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class UserSecurityProvider implements UserProviderInterface, AuthenticatorInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function loadUserByIdentifier(string $identifier): ?User
    {
        return $this->userRepository->loadUserByIdentifier($identifier);
    }

    public function getUserByToken(string $token): ?User
    {
        return $this->userRepository->getUserByToken($token);
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @param UserInterface $user
     * @return UserInterface
     * @throws Exception
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * Tells Symfony to use this provider for this User class.
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class)
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    /**
     * Upgrades the encoded password of a user, typically for using a better hash algorithm.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $request->getSession()->set(Security::LAST_USERNAME, $email);
        return new Passport(
          new UserBadge($email),
          new PasswordCredentials($request->request->get('password', ''))
        );
    }

    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me.
     *
     * If you're not using these features, you do not need to implement
     * this method.
     *
     * @param string $username
     * @return void
     *
     * @throws Exception
     */
    public function loadUserByUsername(string $username)
    {
    }

    public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
    {
        return new /**
         * @method string getUserIdentifier()
         */ class implements TokenInterface {
            public function getRoleNames(): array {
                return [];
            }

            public function serialize()
            {
                // TODO: Implement serialize() method.
            }

            public function unserialize($data)
            {
                // TODO: Implement unserialize() method.
            }

            public function __toString()
            {
                return '';
            }

            public function getCredentials()
            {
                // TODO: Implement getCredentials() method.
            }

            public function getUser()
            {
                // TODO: Implement getUser() method.
            }

            public function setUser($user)
            {
                // TODO: Implement setUser() method.
            }

            public function isAuthenticated()
            {
                // TODO: Implement isAuthenticated() method.
            }

            public function setAuthenticated(bool $isAuthenticated)
            {
                // TODO: Implement setAuthenticated() method.
            }

            public function eraseCredentials()
            {
                // TODO: Implement eraseCredentials() method.
            }

            public function getAttributes()
            {
                // TODO: Implement getAttributes() method.
            }

            public function setAttributes(array $attributes)
            {
                // TODO: Implement setAttributes() method.
            }

            public function hasAttribute(string $name)
            {
                // TODO: Implement hasAttribute() method.
            }

            public function getAttribute(string $name)
            {
                // TODO: Implement getAttribute() method.
            }

            public function setAttribute(string $name, $value)
            {
                // TODO: Implement setAttribute() method.
            }

            public function __serialize(): array
            {
                return [];
            }

            public function __unserialize(array $data): void
            {
                // TODO: Implement __unserialize() method.
            }

            public function getUsername()
            {
                // TODO: Implement getUsername() method.
            }

            public function __call($name, $arguments)
            {
                // TODO: Implement @method string getUserIdentifier()
            }
        };
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new Response(null);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(null);
    }
}
