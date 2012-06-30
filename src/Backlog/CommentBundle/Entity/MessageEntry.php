<?php

namespace Backlog\CommentBundle\Entity;

use Backlog\MarkdownBundle\Markdown\EncoderInterface;

class MessageEntry extends Entry
{
    protected $message;
    protected $messageHtml;

    public function setMessage($message, EncoderInterface $encoder)
    {
        $this->message = $message;
        $this->messageHtml = $encoder->encodeToHtml($message);
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
