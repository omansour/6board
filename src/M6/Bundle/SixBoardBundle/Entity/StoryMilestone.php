<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StoryMilestone
 *
 * @ORM\Table(name="story_milestone")
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 */
class StoryMilestone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer")
     * @Gedmo\SortablePosition
     */
    private $rank;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prioritized", type="boolean")
     */
    private $prioritized = false;

    /**
     * @var Story
     *
     * @ORM\ManyToOne(targetEntity="Story", inversedBy="storyMilestones")
     */
    private $story;

    /**
     * @var Milestone
     *
     * @ORM\ManyToOne(targetEntity="Milestone", inversedBy="stories")
     * @Gedmo\SortableGroup
     */
    private $milestone;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return StoryMilestone
     */
    public function setRank($rank)
    {
        if($this->id != null && $this->rank != $rank) {
            $this->prioritized = true;
        }

        $this->rank = $rank;

        return $this;
    }

    /**
     * unsort a StoryMilestone
     *
     * @return StoryMilestone
     */
    public function unsort()
    {
        if (!is_null($this->getId())) {
            $this->setPrioritized(true);
            $this->setRank(null);
        }

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Get rank but first is first (not zero)
     *
     * @return integer
     */
    public function getReadableRank()
    {
        return $this->rank + 1;
    }

    /**
     * Is prioritized
     *
     * @return boolean
     */
    public function isPrioritized()
    {
        return $this->prioritized;
    }

    /**
     * Set story
     *
     * @param integer $story
     *
     * @return StoryMilestone
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return integer
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set milestone
     *
     * @param integer $milestone
     *
     * @return StoryMilestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;

        return $this;
    }

    /**
     * Get milestone
     *
     * @return integer
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

    /**
     * __toString function
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getMilestone();
    }

    public function setPrioritized($prioritized)
    {
        $this->prioritized = $prioritized;
    }
}
