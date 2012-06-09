<?php

namespace Backlog\AppBundle\Entity\RowProvider;

use Symfony\Component\Form\FormFactoryInterface;

use Backlog\AppBundle\Entity\RowProviderInterface;
use Backlog\AppBundle\Entity\BacklogRow;
use Backlog\AppBundle\Entity\Milestone;

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
        return 'BacklogAppBundle:Milestone:_row.html.twig';
    }

    public function getShowTemplate()
    {
        return 'BacklogAppBundle:Milestone:_card.html.twig';
    }

    public function getEditTemplate()
    {
        return 'BacklogAppBundle:Milestone:_edit.html.twig';
    }

    public function getNewTemplate()
    {
        return 'BacklogAppBundle:Milestone:_new.html.twig';
    }
}
