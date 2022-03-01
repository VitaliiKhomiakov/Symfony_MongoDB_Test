<?php
declare(strict_types=1);

namespace App\Provider;

use App\Document\Link;
use App\Document\User;
use App\Dto\Model\GroupedLinks;
use App\Provider\ProviderInterface\LinkProviderInterface;
use App\Repository\LinkRepository;
use App\Repository\UserRepository;
use App\Service\ShortLink;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LinkProvider extends BaseProvider implements LinkProviderInterface
{
    private Link $link;
    private LinkRepository $linkRepository;
    private UserRepository $userRepository;
    private ShortLink $shortLink;

    public function __construct(
      DocumentManager $documentManager,
      ValidatorInterface $validator,
      LinkRepository $linkRepository,
      UserRepository $userRepository,
      ShortLink $shortLink
    )
    {
        parent::__construct($documentManager, $validator);
        $this->linkRepository = $linkRepository;
        $this->userRepository = $userRepository;
        $this->shortLink = $shortLink;
    }

    /**
     * @throws MongoDBException
     * @throws Exception
     */
    public function createLink(User $user, string $url): void
    {
        $link = new Link();
        $link->setLink($url)
          ->setShortLink($this->shortLink->generate())
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

    /**
     * @throws Exception
     */
    public function getGroupedLinks($userId = '', string $date = null): GroupedLinks
    {
        $user = null;
        if ($userId) {
            $user = $this->userRepository->find($userId);

            if (!$user) {
                throw new Exception('User not Found');
            }
        }

        if ($date && !DateTime::createFromFormat('d-m-Y', $date)) {
            throw new Exception('Incorrect date');
        }

        return $this->linkRepository->getGroupedLinks($user, $date);
    }

}
