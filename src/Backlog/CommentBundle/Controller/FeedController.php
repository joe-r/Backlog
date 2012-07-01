<?php

namespace Backlog\CommentBundle\Controller;

use Backlog\AppBundle\Controller\Controller;

class FeedController extends Controller
{
    public function showBlockAction($uuid)
    {
        $this->throwNotFoundUnless($feed = $this->getRepository('BacklogCommentBundle:Feed')->find($uuid));

        $form = $this->createForm('bl_comment_message');

        return $this->render(
            'BacklogCommentBundle:Feed:showBlock.html.twig',
            array(
                'feed' => $feed,
                'messageForm' => $form->createView()
            )
        );
    }
}
