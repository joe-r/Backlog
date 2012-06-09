<?php

namespace Backlog\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Backlog\AppBundle\Entity\Milestone;
use Backlog\AppBundle\Entity\User;
use Backlog\AppBundle\Entity\Backlog;
use Backlog\AppBundle\DataFixtures\BaseFixture;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LoadMilestoneData extends BaseFixture
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-user');
        $userBacklog  = $this->getReference('backlog-user-basic');

        $milestones = array(
            $this->createMilestone($userBacklog, new \DateTime("+1 day"), 'First milestone', 4),
        );

        foreach ($milestones as $milestone) {
            $manager->persist($milestone);
        }
        $manager->flush();
    }

    protected function createMilestone(Backlog $backlog, \DateTime $dueAt, $title, $position)
    {
        $milestone = new Milestone();
        $milestone->setBacklog($backlog);
        $milestone->setDueAt($dueAt);
        $milestone->setTitle($title);
        $milestone->setPosition($position);

        return $milestone;
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 3;
    }
}
