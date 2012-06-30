<?php

namespace Backlog\BacklogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BacklogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('expiration_hours', 'number')
        ;
    }

    public function getName()
    {
        return 'bl_backlog';
    }
}
