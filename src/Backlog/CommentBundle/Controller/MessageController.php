<?php

namespace Backlog\CommentBundle\Controller;

use Backlog\AppBundle\Controller\Controller;
use Backlog\CommentBundle\Entity\MessageEntry;

class MessageController extends Controller
{
    public function saveNewAction($feed_uuid)
    {
        $referer =
            $this->getRequest()->query->get('referer') ?:
            $this->getRequest()->headers->get('Referer')
        ;

        if (!$referer) {
            throw new \RuntimeException('Unable to determine referer');
        }

        $this->throwNotFoundUnless($feed = $this->getRepository('BacklogCommentBundle:Feed')->find($feed_uuid));

        $form = $this->createForm('bl_comment_message', $entry = new MessageEntry());
        $entry->setAuthor($this->getUser());

        $form->bindRequest($this->getRequest());


        if ($form->isValid()) {
            $feed->addEntry($entry);
            $this->persistAndFlush(array($feed, $entry));

            return $this->redirect($referer);
        }

        throw new \RuntimeException("Bad request");
    }
}
