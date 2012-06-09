<?php

namespace Backlog\AppBundle\Entity;

/**
 * Representation of a milestone.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Milestone extends BacklogRow
{
    /**
     * Title of the milestone.
     *
     * @var string
     */
    protected $title;

    /**
     * Due date for this milestone.
     *
     * @var DateTime
     */
    protected $dueAt;

    /**
     * Creates a new milestone.
     */
    public function __construct()
    {
        parent::__construct();
        $this->complexity = 0;
    }

    /**
     * Returns title of the story.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Changes title of the story.
     *
     * @param string $title A new title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Changes the due date of the milestone.
     *
     * @param DateTime $dueAt A new due at date
     */
    public function setDueAt(\DateTime $dueAt)
    {
        $this->dueAt = $dueAt;
    }

    /**
     * Returns the due date.
     *
     * @return DateTime
     */
    public function getDueAt()
    {
        return $this->dueAt;
    }
}
