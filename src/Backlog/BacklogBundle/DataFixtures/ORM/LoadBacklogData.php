<?php

namespace Backlog\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Backlog\AppBundle\DataFixtures\BaseFixture;
use Backlog\BacklogBundle\Entity\Backlog;
use Backlog\UserBundle\Entity\User;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LoadBacklogData extends BaseFixture
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager)
    {
        $user  = $this->getReference('user-user');
        $admin = $this->getReference('user-admin');

        $backlogs = array(
            'backlog-user-basic' => $this->createBacklog('User basic backlog', $user),
            'backlog-admin-secret' => $this->createBacklog('Admin secret backlog', $admin)
        );

        foreach ($backlogs as $referenceName => $backlog) {
            $manager->persist($backlog);
            $this->setReference($referenceName, $backlog);
        }
        $manager->flush();
    }

    protected function createBacklog($title, User $owner)
    {
        $backlog = new Backlog();
        $backlog->setTitle($title);
        $backlog->setOwner($owner);

        return $backlog;
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 2;
    }
}
