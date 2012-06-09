<?php

namespace Backlog\AppBundle\Entity\RowProvider;

use Symfony\Component\Form\FormFactoryInterface;

use Backlog\AppBundle\Entity\RowProviderInterface;
use Backlog\AppBundle\Entity\BacklogRow;
use Backlog\AppBundle\Entity\Story;

class StoryProvider implements RowProviderInterface
{
    protected $formFactory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->formFactory = $factory;
    }

    public function getLabel()
    {
        return 'Story';
    }

    public function getName()
    {
        return 'story';
    }

    public function getNew()
    {
        return new Story();
    }

    public function supports(BacklogRow $row)
    {
        return $row instanceof Story;
    }

    public function getForm(BacklogRow $row)
    {
        return $this->formFactory->create('bl_story', $row);
    }

    public function getRowTemplate()
    {
        return 'BacklogAppBundle:Story:_row.html.twig';
    }

    public function getShowTemplate()
    {
        return 'BacklogAppBundle:Story:_card.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BacklogAppBundle:Story:_edit.html.twig';
    }

    public function getNewTemplate()
    {
        return 'BacklogAppBundle:Story:_new.html.twig';
    }
}
