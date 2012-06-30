<?php

namespace Backlog\AppBundle\Entity;

use Backlog\AppBundle\Util\UUIDGenerator;

/**
 * Representation of a backlog row.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class BacklogRow
{
    /**
     * Unique identifier of Backlog row
     *
     * @var string
     */
    protected $uid;

    /**
     * Identifier of the backlog row.
     *
     * @var string
     */
    protected $id;

    /**
     * Is row done?
     *
     * @var boolean
     */
    protected $isDone;

    /**
     * Complexity of the backlog row (0 index).
     *
     * @var int
     */
    protected $complexity;

    /**
     * Creation date
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * Indicates the position of element in backlog (0 index).
     *
     * @var int
     */
    protected $position;

    /**
     * Backlog containing the row.
     *
     * @var Backlog
     */
    protected $backlog;

    /**
     * Constructs a new backlog row.
     */
    public function __construct()
    {
        $this->uid = UUIDGenerator::v4();
        $this->createdAt = new \DateTime();
        $this->isDone = false;
    }

    public function isFinishable()
    {
        return true;
    }

    public function finish()
    {
        $this->isDone = true;
    }

    /**
     * Returns unique identifier of the backlog row.
     *
     * @return string
     */
    public function getUId()
    {
        return $this->uid;
    }

    /**
     * Returns identifier of the backlog row.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Changes the identifier.
     *
     * @param int $id New identifier
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns complexity of the row.
     *
     * @return int
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * Changes complexity of the task.
     *
     * @param int $complexity A complexity (0 indexed)
     */
    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;
    }

    /**
     * Returns the creation date of the object.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns position of the object in backlog (0 indexed).
     *
     * @return int Position of row in backlog (starts from 0)
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Changes position of row in backlog.
     *
     * @param int $position New position of the row
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Defines backlog of the row.
     *
     * @param Backlog A Backlog to associate row to
     */
    public function setBacklog(Backlog $backlog)
    {
        $this->backlog = $backlog;
    }

    public function getBacklog()
    {
        return $this->backlog;
    }

    public function isDone()
    {
        return $this->isDone;
    }

    public function setDone($isDone = true)
    {
        $this->isDone = $isDone;
    }
}
