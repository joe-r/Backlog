<?php

namespace Backlog\AppBundle\Entity;

interface RowProviderInterface
{
    public function getName();
    public function getLabel();
    public function getNew();
    public function supports(BacklogRow $row);
    public function getForm(BacklogRow $row);
    public function getRowTemplate();
    public function getShowTemplate();
    public function getEditTemplate();
    public function getNewTemplate();
}
