<?php

declare(strict_types=1);

namespace App\Dto\Model;

class Link {

    private string $id;
    private string $link;
    private string $shortLink;

    public function __construct(string $id, string $link, string $shortLink)
    {
        $this->id = $id;
        $this->link = $link;
        $this->shortLink = $shortLink;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getShortLink(): string
    {
        return $this->shortLink;
    }
}
