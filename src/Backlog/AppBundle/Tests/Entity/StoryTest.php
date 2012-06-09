<?php

namespace Backlog\AppBundle\Tests\Entity;

use Backlog\AppBundle\Entity\Story;

class StoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialState()
    {
        $story = new Story();
        $tags = $story->getTags();
        $this->assertTrue(is_array($tags), "Initial tags is an array");
        $this->assertCount(0, $tags, "No tag on story at the beginning");
    }

    public function testAddTag()
    {
        $story = new Story();
        $story->addTag('foo');
        $this->assertEquals(array('foo'), $story->getTags(), "Tag can be added to story");
        $story->addTag('bar');
        $this->assertEquals(array('foo', 'bar'), $story->getTags(), "Tag can be added to story");
    }

    public function testRemoveTag()
    {
        $story = new Story();
        $story->addTag('foo');
        $story->addTag('bar');
        $story->removeTag('foo');
        $this->assertNotContains('foo', $story->getTags(), "Tag foo is removed");
        $this->assertContains('bar', $story->getTags(), "Tag bar is still present");
    }
}
