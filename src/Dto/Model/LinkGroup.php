<?php

declare(strict_types=1);

namespace App\Dto\Model;

use Assert\Assertion;

class LinkGroup
{
    private User $user;
    private array $linkList;

    public function __construct(User $user, array $linkList)
    {
        $this->user = $user;

        Assertion::allIsInstanceOf($linkList, Link::class);

        $this->linkList = $linkList;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Link[]
     */
    public function getLinkList(): array
    {
        return $this->linkList;
    }
}
