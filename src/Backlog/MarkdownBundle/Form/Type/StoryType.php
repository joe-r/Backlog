<?php

namespace Backlog\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('complexity', 'number')
            ->add('description', 'bl_markdown')
        ;
    }

    public function getName()
    {
        return 'bl_story';
    }
}
