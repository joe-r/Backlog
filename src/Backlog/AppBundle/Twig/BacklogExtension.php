<?php

namespace Backlog\AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormView;

use Backlog\AppBundle\Entity\BacklogRow;
use Backlog\AppBundle\Entity\Milestone;
use Backlog\AppBundle\Entity\Story;

class BacklogExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    protected $environment;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getTests()
    {
        return array(
            'bl_story'     => new \Twig_Test_Method($this, 'isStory'),
            'bl_milestone' => new \Twig_Test_Method($this, 'isMilestone'),
        );
    }

    public function getFunctions()
    {
        return array(
            'bl_row_providers' => new \Twig_Function_Method($this, 'getRowProviders'),
            'bl_row_show' => new \Twig_Function_Method($this, 'renderRowShow', array('is_safe' => array('html'))),
            'bl_row_row' => new \Twig_Function_Method($this, 'renderRowRow', array('is_safe' => array('html'))),
            'bl_row_edit' => new \Twig_Function_Method($this, 'renderRowEdit', array('is_safe' => array('html'))),
            'bl_row_new'  => new \Twig_Function_Method($this, 'renderRowNew',  array('is_safe' => array('html'))),
        );
    }

    public function renderRowRow(BacklogRow $row, BacklogRow $active = null)
    {
        $tpl = $this->container->get('bl_app.row_manager')->getProvider($row)->getRowTemplate();
        return $this->environment->render($tpl, array(
            'row'   => $row,
            'active' => $active
        ));
    }

    public function renderRowShow(BacklogRow $row)
    {
        $tpl = $this->container->get('bl_app.row_manager')->getProvider($row)->getShowTemplate();
        return $this->environment->render($tpl, array(
            'row'   => $row
        ));
    }

    public function renderRowEdit(BacklogRow $row, FormView $form)
    {
        $tpl = $this->container->get('bl_app.row_manager')->getProvider($row)->getEditTemplate();
        return $this->environment->render($tpl, array(
            'row'   => $row,
            'form' => $form
        ));
    }

    public function renderRowNew(BacklogRow $row, FormView $form, $type)
    {
        $tpl = $this->container->get('bl_app.row_manager')->getProvider($row)->getNewTemplate();
        return $this->environment->render($tpl, array(
            'row'   => $row,
            'form'  => $form,
            'type'  => $type
        ));
    }

    public function getRowProviders()
    {
        return $this->container->get('bl_app.row_manager')->getProviders();
    }

    public function isStory($value)
    {
        return $value instanceof Story;
    }

    public function isMilestone($value)
    {
        return $value instanceof Milestone;
    }

    public function getName()
    {
        return 'bl_backlog';
    }
}
