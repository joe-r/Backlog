<?php

namespace Backlog\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Backlog\AppBundle\Entity\Story;
use Backlog\AppBundle\Entity\User;
use Backlog\AppBundle\Entity\Backlog;
use Backlog\AppBundle\DataFixtures\BaseFixture;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LoadStoryData extends BaseFixture
{
    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-user');
        $userBacklog  = $this->getReference('backlog-user-basic');

        // Objects are inserted voluntary in disorder, to be sure position is correctly handled
        $stories = array(
            $this->createStory($userBacklog, null,  'Post milestone story', 5, 3),
            $this->createStory($userBacklog, $user, 'Third story',          3, 2),
            $this->createStory($userBacklog, $user, 'First story',          1, 1),
            $this->createStory($userBacklog, $user, 'Second story',         2, 2),
        );

        foreach ($stories as $story) {
            $manager->persist($story);
        }
        $manager->flush();
    }

    protected function createStory(Backlog $backlog, User $assignee = null, $title, $position, $complexity)
    {
        $story = new Story();
        if ($assignee) {
            $story->setAssignee($assignee);
        }

        $story->setTitle($title);
        $story->setBacklog($backlog);
        $story->setPosition($position);
        $story->setComplexity($complexity);

        return $story;
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 3;
    }
}
