<?php

namespace Backlog\CommentBundle\Entity;

use Backlog\AppBundle\Util\UUIDGenerator;

use Backlog\UserBundle\Entity\User;
use Backlog\CommentBundle\Entity\Feed;

abstract class Entry
{
    protected $uuid;
    protected $feed;
    protected $author;
    protected $createdAt;

    public function __construct()
    {
        $this->uuid = UUIDGenerator::v4();
        $this->createdAt = new \DateTime();
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function hasAuthor()
    {
        return null !== $this->author;
    }

    public function setFeed(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function getFeed()
    {
        return $this->feed;
    }
}
