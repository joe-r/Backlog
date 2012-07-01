<?php

namespace Backlog\CommentBundle\Entity;

use Backlog\AppBundle\Util\UUIDGenerator;
use Backlog\MarkdownBundle\Markdown\ConverterInterface;

class FileEntry extends Entry
{
    protected $filename;
    protected $objectIdentifier;
    protected $mimeType;
    protected $description;
    protected $descriptionHtml;

    public function __construct()
    {
        $this->uuid = UUIDGenerator::v4();
        $this->createdAt = new \DateTime();
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setDescription($description, ConverterInterface $converter)
    {
        $this->description = $description;
        $this->descriptionHtml = $converter->convertToHtml($description);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDescriptionHtml()
    {
        return $this->descriptionHtml;
    }
}
