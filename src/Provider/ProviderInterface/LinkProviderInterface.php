<?php
declare(strict_types=1);

namespace App\Provider\ProviderInterface;

use App\Document\Link;
use App\Document\User;
use App\Dto\Model\LinkGroupList;
use App\Repository\LinkRepository;
use App\Repository\UserRepository;
use App\Service\ShortLink;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface LinkProviderInterface
{
    public function __construct(
      DocumentManager $documentManager,
      ValidatorInterface $validator,
      LinkRepository $linkRepository,
      UserRepository $userRepository,
      ShortLink $shortLink
    );

    public function createLink(User $user, string $url);
    public function setLink(Link $link);
    public function getLink(): Link;

    public function getLinks(int $offset, int $limit): array;
    public function getTotal(): int;

    public function getFullLink(string $shortUrl): ?string;

    public function getLinkGroupList($userId = '', string $date = null): LinkGroupList;
}
