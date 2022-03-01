<?php

namespace App\Migrations;

use AntiMattr\MongoDB\Migrations\AbstractMigration;
use App\Document\Link;
use App\Document\Token;
use App\Document\User;
use App\Service\ShortLink;
use MongoDB\Database;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20220226224956 extends AbstractMigration implements ContainerAwareInterface
{
    private ContainerInterface $container;
    private ShortLink $shortLink;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->shortLink = new ShortLink();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return "";
    }

    public function up(Database $db)
    {
        $documentManager = $this->container->get('doctrine_mongodb.odm.document_manager');
        $usersData = $this->getUserData();

        foreach ($usersData as $userData) {
            $user = $this->getPreparedUser($userData['name'], $userData['email']);
            $documentManager->persist($user);
            // save to get userId
            $documentManager->flush();

            $token = $this->getPreparedToken($user);
            $documentManager->persist($token);

            foreach ($userData['links'] as $link) {
                $preparedLink = $this->getPreparedLink($user, $link);
                $documentManager->persist($preparedLink);
            }

            $documentManager->flush();
        }
    }

    public function down(Database $db)
    {
        $documentManager = $this->container->get('doctrine_mongodb.odm.document_manager');

        $userBuilder = $documentManager->createQueryBuilder(User::class);
        $tokenBuilder = $documentManager->createQueryBuilder(Token::class);
        $linkBuilder = $documentManager->createQueryBuilder(Link::class);

        $usersData = $this->getUserData();

        foreach ($usersData as $userData)
        {
            $user = $userBuilder->field('email')->equals($userData['email'])->getQuery()->getSingleResult();
            $documentManager->remove($user);

            $token = $tokenBuilder->field('user')->equals($user)->getQuery()->getSingleResult();
            $documentManager->remove($token);

            $links = $linkBuilder->field('user')->equals($user)->getQuery()->execute();
            foreach ($links as $link) {
                $documentManager->remove($link);
            }
        }

        $documentManager->flush();
    }

    private function getPreparedUser(string $name, string $email): User
    {
        $user = new User();
        $user->setName($name)
          ->setEmail($email)
          ->setRoles(['STANDARD_USER']);

        return $user;
    }

    private function getPreparedToken(User $user): Token
    {
        $token = new Token();
        $token->setUser($user);
        $token->setToken('user_token_' . $user->getId());

        return $token;
    }

    private function getPreparedLink(User $user, string $url): Link
    {
        $link = new Link();
        $link->setUser($user);
        $link->setLink($url);
        $link->setShortLink($this->shortLink->generate());
        $link->setDate(new \DateTime());
        return $link;
    }

    private function getUserData(): array
    {
        return [
          [
            'email' => 'alex@mail.com',
            'name' => 'Alex',
            'links' => [
              'https://yandex.ru',
              'https://rabler.ru',
              'https://sandbox.onlinephpfunctions.com/',
              'https://www.php.net/get-involved',
            ]
          ],
          [
            'email' => 'paul@mail.com',
            'name' => 'Paul',
            'links' => [
              'https://google.com',
            ]
          ],
          [
            'email' => 'vitaly@mail.com',
            'name' => 'Vitaly',
            'links' => []
          ]
        ];
    }
}
