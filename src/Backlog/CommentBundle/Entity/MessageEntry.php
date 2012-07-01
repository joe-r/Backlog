<?php

namespace Backlog\CommentBundle\Entity;

use Backlog\MarkdownBundle\Markdown\ConverterInterface;

class MessageEntry extends Entry
{
    protected $message;
    protected $messageHtml;

    public function setMessage($message, ConverterInterface $encoder)
    {
        $this->message = $message;
        $this->messageHtml = $encoder->convertToHtml($message);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getMessageHtml()
    {
        return $this->messageHtml;
    }
}
