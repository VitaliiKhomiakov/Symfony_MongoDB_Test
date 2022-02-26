<?php

namespace App\Repository;

use App\Document\Link;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;

class LinkRepository
{
    private Builder $builder;

    public function __construct(DocumentManager $documentManager)
    {
        $this->builder = $documentManager->createQueryBuilder(Link::class);
    }

    public function getLinks($offset = 0, $limit = 20): array
    {
        return $this->builder
          ->select('shortLink')
          ->skip($offset)
          ->limit($limit)
          ->getQuery()
          ->toArray();
    }

    public function getTotal(): int
    {
        return $this->builder->count()->getQuery()->execute();
    }

    public function getFullLink(string $shortLink): ?string
    {
        $link = $this->builder
          ->select('link')
          ->field('shortLink')
          ->equals($shortLink)
          ->getQuery()
          ->getSingleResult();

        return $link ? $link->getLink() : null;
    }
}
