<?php

namespace Backlog\BacklogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Backlog\UserBundle\Entity\User;

/**
 * Backlog object.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Backlog
{
    const DEFAULT_EXPIRATION_HOURS = 8;

    /**
     * Unique identifier of backlog.
     *
     * @var string
     */
    protected $uid;

    /**
     * Title of backlog
     *
     * @var string
     */
    protected $title;

    /**
     * Number of hours before a row is considered as "expired"
     *
     * @var integer
     */
    protected $expirationHours;
    /**
     * Owner of the backlog
     *
     * @var User
     */
    protected $owner;

    /**
     * Rows of the backlog
     *
     * @var array
     */
    protected $rows;

    /**
     * Creates a new backlog.
     */
    public function __construct()
    {
        $this->expirationHours = self::DEFAULT_EXPIRATION_HOURS;
        $this->uid  = sprintf('%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xfff));
        $this->rows = new ArrayCollection();
    }

    /**
     * Returns UID of the backlog.
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Returns owner of the backlog.
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Changes owner of the backlog.
     *
     * @param User $user New owner of backlog.
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Returns title of the backlog.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Changes title of the backlog.
     *
     * @param string $title New title to set
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns number of hours before a row is considered as expired
     *
     * @return int
     */
    public function getExpirationHours()
    {
        return $this->expirationHours;
    }

    /**
     * Changes the value of hours before a row is expired
     *
     * @param int $expirationHours New value
     */
    public function setExpirationHours($expirationHours)
    {
        $this->expirationHours = $expirationHours;
    }

    public function getRows()
    {
        return $this->rows;
    }
}
