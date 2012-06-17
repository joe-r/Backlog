<?php

namespace Backlog\AppBundle\Entity;

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
     * Description of the story
     *
     * @var string
     */
    protected $descriptionRst;
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
     * Returns RST description of the story.
     *
     * @return string A text in RST format
     */
    public function getDescriptionRst()
    {
        return $this->descriptionRst;
    }

    /**
     * Changes RST description of the story.
     *
     * @param string $descriptionRst New RST description to set
     */
    public function setDescriptionRst($descriptionRst)
    {
        $this->descriptionRst = $descriptionRst;
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
     * Changes HTML description of the story.
     *
     * @param string $descriptionHtml New HTML description to set
     */
    public function setDescriptionHtml($descriptionHtml)
    {
        $this->descriptionHtml = $descriptionHtml;
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
            'title' => $this->title
        ));
    }
}
