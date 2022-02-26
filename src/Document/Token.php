<?php
declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Document(collection="token")
 */
class Token
{
    /**
     * @Id
     */
    private string $id;

    /**
     * @ReferenceOne(targetDocument=User::class)
     * @Assert\NotBlank
     */
    private User $user;

    /**
     * @Field(type="string")
     * @Assert\NotBlank
     */
    private string $token;

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
