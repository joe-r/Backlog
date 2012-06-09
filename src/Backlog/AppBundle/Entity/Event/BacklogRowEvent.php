<?php

namespace Backlog\AppBundle\Entity\Event;

use Backlog\AppBundle\Entity\BacklogRow;

class BacklogRowEvent
{
    private $row;

    public function __construct(BacklogRow $row)
    {
        $this->row = $row;
    }

    public function getRow()
    {
        return $this->row;
    }
}
