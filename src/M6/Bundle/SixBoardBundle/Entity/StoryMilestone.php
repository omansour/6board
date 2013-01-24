<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StoryMilestone
 *
 * @ORM\Table(name="story_milestone")
 * @ORM\Entity
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
     * @var Story
     *
     * @ORM\ManyToOne(targetEntity="Story", inversedBy="milestones")
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
        $this->rank = $rank;

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
}
