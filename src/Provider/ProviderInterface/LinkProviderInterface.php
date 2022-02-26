<?php
declare(strict_types=1);

namespace App\Provider\ProviderInterface;

use App\Document\Link;
use App\Document\User;
use App\Repository\LinkRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface LinkProviderInterface
{
    public function __construct(DocumentManager $documentManager, ValidatorInterface $validator, LinkRepository $linkRepository);

    public function createLink(User $user, string $url);
    public function setLink(Link $link);
    public function getLink(): Link;

    public function getLinks(int $offset, int $limit): array;
    public function getTotal(): int;

    public function getFullLink(string $shortUrl): ?string;
}
