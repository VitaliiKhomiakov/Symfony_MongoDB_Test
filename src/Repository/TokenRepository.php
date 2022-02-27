<?php

namespace App\Repository;

use App\Document\Token;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;

class TokenRepository
{
    private Builder $builder;

    public function __construct(DocumentManager $documentManager)
    {
        $this->builder = $documentManager->createQueryBuilder(Token::class);
    }

    public function getUserByToken(string $token): ?User
    {
        return $this->builder->field('token')->equals($token)->getQuery()->getSingleResult();
    }
}
