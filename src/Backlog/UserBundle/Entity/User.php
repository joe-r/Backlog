<?php

namespace Backlog\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Representation of a backlog user.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class User implements UserInterface
{
    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Initials of the user
     *
     * @var string
     */
    protected $initials;

    /**
     * Fullname of the user (for displaying).
     *
     * @var string
     */
    protected $fullname;

    /**
     * Email address
     *
     * @var string
     */
    protected $email;

    /**
     * Encoded password
     *
     * @var string
     */
    protected $password;

    /**
     * Salt of the encoded password
     *
     * @var string
     */
    protected $salt;

    /**
     * Backlogs of the user
     *
     * @var array
     */
    protected $backlogs;

    /**
     * Roles of the user
     *
     * @var array
     */
    protected $roles;

    /**
     * Creates a new user.
     */
    public function __construct()
    {
        $this->backlogs = new ArrayCollection();
    }

    /**
     * Returns user's UID.
     *
     * @êeturn string
     */
    public function getUID()
    {
        return $this->uid;
    }

    /**
     * Sets the user's username.
     *
     * @param string $username Username to set
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returns username.
     *
     * @return string A username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the user's initials.
     *
     * @param string $initials Initials to set
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;
    }

    /**
     * Returns initials.
     *
     * @return string A initials
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * Sets the user's fullname.
     *
     * @param string $fullname Fullname to set
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * Returns fullname.
     *
     * @return string A fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Changes the user email.
     *
     * @param string $email A email address
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the user's email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the user's password salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the user encoded password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Changes the user password.
     *
     * @param string                   $raw     The raw password to set
     * @param PasswordEncoderInterface $encoder The password encoder to use.
     */
    public function setPassword($raw, PasswordEncoderInterface $encoder)
    {
        $this->salt = md5(uniqid().microtime());
        $this->password = $encoder->encodePassword($raw, $this->salt);
    }

    /**
     * Returns user backlogs.
     *
     * @return array
     */
    public function getBacklogs()
    {
        return $this->backlogs;
    }

    /**
     * Returns roles of the user.
     *
     * @return array An array of roles
     */
    public function getRoles()
    {
        return $this->username == 'admin' ? array('ROLE_ADMIN') : array('ROLE_USER');
    }

    /**
     * Removes sensitive data from the object.
     */
    public function eraseCredentials()
    {
    }

    public function equals($value)
    {
        return $value instanceof User && $value->getUsername() == $this->username;
    }
}
