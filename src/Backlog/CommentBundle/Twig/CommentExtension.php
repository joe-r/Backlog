<?php

namespace Backlog\CommentBundle\Twig;

use Backlog\CommentBundle\Entity\MessageEntry;

class CommentExtension extends \Twig_Extension
{
    public function getTests()
    {
        return array(
            'comment_message' => new \Twig_Test_Method($this, 'isCommentMessage')
        );
    }

    public function isCommentMessage($message)
    {
        return $message instanceof MessageEntry;
    }

    public function getName()
    {
        return 'bl_comment';
    }
}
