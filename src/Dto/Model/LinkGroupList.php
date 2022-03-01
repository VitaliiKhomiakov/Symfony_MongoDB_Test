<?php

declare(strict_types=1);

namespace App\Dto\Model;

use Assert\Assertion;

class LinkGroupList
{
    private array $linkGroupList;

    public function __construct(array $linkGroupList)
    {
        Assertion::allIsInstanceOf($linkGroupList, LinkGroup::class);

        $this->linkGroupList = $linkGroupList;
    }

    /**
     * @return LinkGroup[]
     */
    public function getLinkGroupLinks(): array
    {
        return $this->linkGroupList;
    }
}
