<?php

namespace Backlog\CommentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'bl_markdown')
        ;
    }

    public function getName()
    {
        return 'bl_comment_message';
    }
}
