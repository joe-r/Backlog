<?php

namespace Backlog\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Backlog\AppBundle\Entity\User;
use Backlog\AppBundle\DataFixtures\BaseFixture;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LoadUserData extends BaseFixture
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager)
    {
        $users = array(
            'user-user'   => $this->createUser('user', 'user',   'user@example.org', 'User',   'US'),
            'user-admin'  => $this->createUser('admin', 'admin', 'admin@example.org', 'Admin', 'AD'),
        );

        foreach ($users as $referenceName => $user) {
            $manager->persist($user);
            $this->setReference($referenceName, $user);
        }
        $manager->flush();
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 1;
    }

    protected function createUser($username, $password, $email, $fullname, $initials)
    {
        $user = new User();
        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);

        $user->setUsername($username);
        $user->setPassword($password, $encoder);
        $user->setEmail($email);
        $user->setFullname($fullname);
        $user->setInitials($initials);

        return $user;
    }

}
