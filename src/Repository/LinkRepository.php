<?php
declare(strict_types=1);

namespace App\Repository;

use App\Document\Link;
use App\Document\User;
use App\Dto\Model\LinkGroup;
use App\Dto\Model\LinkGroupList;
use App\Dto\Model\LinkList;
use App\Dto\Model\User as UserData;
use App\Dto\Model\Link as LinkData;
use App\Dto\Model\GroupedLinks;
use Doctrine\ODM\MongoDB\Aggregation\Aggregation;
use Doctrine\ODM\MongoDB\Aggregation\Builder as AggregationBuilder;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;

class LinkRepository
{
    private Builder $builder;
    private AggregationBuilder $aggregationBuilder;

    public function __construct(DocumentManager $documentManager)
    {
        $this->aggregationBuilder = $documentManager->createAggregationBuilder(Link::class);
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

    public function getLinkGroupList(?User $user, ?string $date): LinkGroupList
    {
        $q = $this->aggregationBuilder;
        if ($user) {
            $q->match()
              ->field('user')
              ->references($user);
        }

        if ($date) {
            $q->match()
              ->field('date')
              ->gte($date);
        }

        $linksData = $q->group()
          ->field('id')
          ->expression('$user')
          ->field('link')
          ->push(['id'=> '$id', 'link' => '$link', 'shortLink' => '$shortLink'])
          ->getAggregation();

        return new LinkGroupList($this->prepareGroupLinks($linksData));
    }

    private function prepareGroupLinks(Aggregation $aggregation): array
    {
        $groupedLinks = [];
        foreach ($aggregation as $data) {
            $user = new UserData((string)$data['_id']['$id']);
            $links = $this->prepareLinks($data['link']);
            $groupedLinks[] = new LinkGroup($user, $links);
        }

        return $groupedLinks;
    }

    private function prepareLinks(array $links): array
    {
        $preparedLinks = [];
        foreach ($links as $link) {
            $preparedLinks[] = new LinkData((string)$link['id'], $link['link'], $link['shortLink']);
        }
        return $preparedLinks;
    }
}
