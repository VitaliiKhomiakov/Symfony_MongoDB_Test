<?php
declare(strict_types=1);

namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Document(collection="link")
 */
class Link
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
     * @Assert\Length(min=5)
     */
    private string $link;

    /**
     * @Field(type="string")
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     */
    private string $shortLink;

    /**
     * @Field(type="date")
     * @Assert\NotBlank
     * @Assert\Type("\DateTimeInterface")
     */
    private DateTime $date;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function setShortLink(string $shortLink): self
    {
        $this->shortLink = $shortLink;
        return $this;
    }

    public function setDate(DateTime $dateTime): self
    {
        $this->date = $dateTime;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getShortLink(): string
    {
        return $this->shortLink;
    }

    public function getDateTime(): DateTime
    {
        return $this->date;
    }
}
