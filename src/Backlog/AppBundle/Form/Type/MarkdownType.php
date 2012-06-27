<?php

namespace Backlog\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Backlog\AppBundle\Markdown\ConverterInterface;
use Backlog\AppBundle\Form\Mapper\MarkdownPath;

class MarkdownType extends AbstractType
{
    protected $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $name = $builder->getName();
        $converter = $this->converter;

        $builder
            ->addEventListener(FormEvents::SET_DATA, function (FormEvent $event) use ($name, $converter) {
                $config = $event->getForm()->getConfig();

                $p = new \ReflectionProperty($config, 'propertyPath');

                $new = new MarkdownPath($name, $converter);
                $p->setAccessible(true);
                $p->setValue($config, $new);
            })
        ;
    }

    public function getName()
    {
        return 'bl_markdown';
    }

    public function getParent()
    {
        return 'textarea';
    }
}
