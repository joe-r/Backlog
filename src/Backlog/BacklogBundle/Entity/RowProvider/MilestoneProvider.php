<?php

namespace Backlog\BacklogBundle\Entity\RowProvider;

use Symfony\Component\Form\FormFactoryInterface;

use Backlog\BacklogBundle\Entity\RowProviderInterface;
use Backlog\BacklogBundle\Entity\BacklogRow;
use Backlog\BacklogBundle\Entity\Milestone;

class MilestoneProvider implements RowProviderInterface
{
    protected $formFactory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->formFactory = $factory;
    }

    public function getLabel()
    {
        return 'Milestone';
    }

    public function getName()
    {
        return 'milestone';
    }
    public function getNew()
    {
        return new Milestone();
    }

    public function supports(BacklogRow $row)
    {
        return $row instanceof Milestone;
    }

    public function getForm(BacklogRow $row)
    {
        return $this->formFactory->create('bl_milestone', $row);
    }

    public function getRowTemplate()
    {
        return 'BacklogBacklogBundle:Milestone:_row.html.twig';
    }

    public function getShowTemplate()
    {
        return 'BacklogBacklogBundle:Milestone:_card.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BacklogBacklogBundle:Milestone:_edit.html.twig';
    }

    public function getNewTemplate()
    {
        return 'BacklogBacklogBundle:Milestone:_new.html.twig';
    }
}
