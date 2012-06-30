<?php

namespace Backlog\BacklogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MilestoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('dueAt', 'date')
        ;
    }

    public function getName()
    {
        return 'bl_milestone';
    }
}
