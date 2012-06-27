<?php

namespace Backlog\AppBundle\Entity;

use Backlog\AppBundle\Markdown\ConverterInterface;

/**
 * Representation of a story.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Story extends BacklogRow
{
    const TAG_PATTERN = "#^[^ \n,]{3,}$#";

    /**
     * Title of story
     *
     * @var string
     */
    protected $title;

    /**
     * User assigned to this story.
     *
     * @var User
     */
    protected $assignee;

    /**
     * Description of the story (markdown)
     *
     * @var string
     */
    protected $description;
    protected $descriptionHtml;

    /**
     * Tags of the story.
     *
     * @var array
     */
    protected $tags = array();

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
     * Returns assignee of the story.
     *
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * Changes assignee of the story.
     *
     * @param User $user New assignee to set for this story.
     */
    public function setAssignee(User $user)
    {
        $this->assignee = $user;
    }

    public function isAssignee($value)
    {
        return $this->assignee && $this->assignee->equals($value);
    }

    public function isAssigned()
    {
        return null !== $this->assignee;
    }

    /**
     * Changes description of the story.
     *
     * @param string $description New markdown description to set
     */
    public function setDescription($markdown, ConverterInterface $converter = null)
    {
        if (null === $converter && $markdown !== $this->description) {
            throw new \InvalidArgumentException('Cannot change description without a markdown converter');
        }

        $this->description     = $markdown;
        $this->descriptionHtml = $converter->convertToHtml($markdown);
    }

    /**
     * Returns markdown description of the story.
     *
     * @return string A text in markdown format
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns HTML description of the story.
     *
     * @return string A text in HTML format
     */
    public function getDescriptionHtml()
    {
        return $this->descriptionHtml;
    }

    /**
     * Returns tags of the story.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }
    }

    public function hasTag($tag)
    {
        return in_array($tag, $this->tags);
    }

    public function removeTag($tag)
    {
        if (!in_array($tag, $this->tags)) {
            throw new \InvalidArgumentException(sprintf('The tag "%s" is not present, so not removable'));
        }

        $this->tags = array_diff($this->tags, array($tag));
    }

    public function toJSON()
    {
        return array_merge(parent::toJSON(), array(
            'type'  => 'story',
            'tags'  => $this->tags,
            'title' => $this->title,
            'description' => $this->description,
            'description_html' => $this->descriptionHtml,
        ));
    }
}
