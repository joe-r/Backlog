<?php

namespace Backlog\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Backlog\AppBundle\Markdown\ConverterInterface;

class StoryType extends AbstractType
{
    protected $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $converter = $this->converter;

        $builder
            ->add('title', 'text')
            ->add('complexity', 'number')
            ->add('description', 'textarea', array(
                'required' => false,
                'mapped'   => false
            ))
            ->addEventListener(FormEvents::SET_DATA, function (FormEvent $event) {
                //$event->getForm()->get('description')->setData($event->getData()->getDescriptionMarkdown());
            })
            ->addEventListener(FormEvents::BIND, function (FormEvent $event) use ($converter) {
                $story = $event->getData();
                if (!$story instanceof Story) {
                    throw new \RuntimeException('Data for story form should be a story');
                }

                $markdown = $event->getForm()->get('description')->getData();
                if (null === $markdown) {
                    return;
                }

                $story->setDescription($markdown, $converter);
            });
        ;
    }

    public function getName()
    {
        return 'bl_story';
    }
}
