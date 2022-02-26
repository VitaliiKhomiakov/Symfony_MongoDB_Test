<?php
declare(strict_types=1);

namespace App\Provider;

use App\Document\Link;
use App\Document\User;
use App\Provider\ProviderInterface\LinkProviderInterface;
use App\Repository\LinkRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LinkProvider extends BaseProvider implements LinkProviderInterface
{
    private Link $link;
    private LinkRepository $linkRepository;

    public function __construct(
      DocumentManager $documentManager,
      ValidatorInterface $validator,
      LinkRepository $linkRepository
    )
    {
        parent::__construct($documentManager, $validator);
        $this->linkRepository = $linkRepository;
    }

    /**
     * @throws MongoDBException
     * @throws Exception
     */
    public function createLink(User $user, string $url): void
    {
        $link = new Link();
        $link->setLink($url)
          ->setShortLink(base64_encode(substr(str_shuffle($url), 0, 7)))
          ->setUser($user)
          ->setDate(new \DateTime());

        $this->validate($link);

        $this->documentManager->persist($link);
        $this->documentManager->flush();

        $this->setLink($link);
    }

    public function setLink(Link $link): void
    {
        $this->link = $link;
    }

    public function getLink(): Link
    {
        return $this->link;
    }

    public function getLinks($offset = 0, $limit = 20): array
    {
        return $this->linkRepository->getLinks($offset, $limit);
    }

    public function getTotal(): int
    {
        return $this->linkRepository->getTotal();
    }

    public function getFullLink(string $shortUrl): ?string
    {
        return $this->linkRepository->getFullLink($shortUrl);
    }

}
