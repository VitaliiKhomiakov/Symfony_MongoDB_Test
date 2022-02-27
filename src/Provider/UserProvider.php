<?php
declare(strict_types=1);

namespace App\Provider;

use App\Document\User;
use App\Dto\Request\CreateUserRequest;
use App\Provider\ProviderInterface\UserProviderInterface;
use Doctrine\ODM\MongoDB\MongoDBException;

class UserProvider extends BaseProvider implements UserProviderInterface
{
    private User $user;

    /**
     * @param CreateUserRequest $createUserRequest
     * @throws MongoDBException
     */
    public function createUser(CreateUserRequest $createUserRequest): void
    {
        $user = new User();
        $user->setName($createUserRequest->getName())
          ->setEmail($createUserRequest->getEmail());

        $this->validate($user);

        $this->documentManager->persist($user);
        $this->documentManager->flush();

        $this->setUser($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
