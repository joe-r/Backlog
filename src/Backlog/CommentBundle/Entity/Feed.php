<?php

namespace Backlog\CommentBundle\Entity;

use Backlog\AppBundle\Util\UUIDGenerator;
use Doctrine\Common\Collections\ArrayCollection;

class Feed
{
    protected $uuid;
    protected $createdAt;
    protected $entries;

    public function __construct()
    {
        $this->uuid = UUIDGenerator::v4();
        $this->createdAt = new \DateTime();
        $this->entries = new ArrayCollection();
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function addEntry(Entry $entry)
    {
        $entry->setFeed($this);
        $this->entries[] = $entry;
    }
}
