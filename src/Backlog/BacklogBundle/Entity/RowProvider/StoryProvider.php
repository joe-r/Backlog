<?php

namespace Backlog\BacklogBundle\Entity\RowProvider;

use Symfony\Component\Form\FormFactoryInterface;

use Backlog\BacklogBundle\Entity\RowProviderInterface;
use Backlog\BacklogBundle\Entity\BacklogRow;
use Backlog\BacklogBundle\Entity\Story;

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
        return 'BacklogBacklogBundle:Story:_row.html.twig';
    }

    public function getShowTemplate()
    {
        return 'BacklogBacklogBundle:Story:_card.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BacklogBacklogBundle:Story:_edit.html.twig';
    }

    public function getNewTemplate()
    {
        return 'BacklogBacklogBundle:Story:_new.html.twig';
    }
}
