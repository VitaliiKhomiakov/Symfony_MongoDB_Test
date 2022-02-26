<?php

namespace App\Repository;

use App\Document\Token;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository implements UserLoaderInterface, ObjectRepository
{
    private Builder $builder;

    public function __construct(DocumentManager $documentManager)
    {
        $this->builder = $documentManager->createQueryBuilder(User::class);
    }

    public function loadUserByIdentifier(string $identifier): ?User
    {
        return $this->find($identifier);
    }

    public function find($id): ?User
    {
        return $this->builder->field('id')->equals($id)->getQuery()->getSingleResult();
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = 20, $offset = 0): ?array
    {
        $q = $this->builder
          ->limit($limit)
          ->skip($offset);

        if ($criteria) {
            // TODO: add support for multiple values
            $criteriaKey = key($criteria);

            $q->field($criteriaKey)
                ->equals($criteria[$criteriaKey]);
        }

        if ($orderBy) {
            $q->sort($orderBy);
        }

        return $q->getQuery()->execute();
    }

    public function getUserByToken(string $token): ?User
    {
        $tokenDocument = $this->builder->find(Token::class)
            ->field('token')
            ->equals($token)
            ->getQuery()
            ->getSingleResult();

        return $tokenDocument ? $tokenDocument->getUser() : null;
    }

    public function findOneBy(array $criteria)
    {
        // TODO: Implement findOneBy() method.
    }

    public function getClassName()
    {
        // TODO: Implement getClassName() method.
    }

    public function loadUserByUsername(string $usernameOrEmail)
    {
        // TODO: Implement loadUserByUsername() method
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.
    }
}
