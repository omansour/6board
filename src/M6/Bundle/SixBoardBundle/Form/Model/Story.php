<?php


namespace M6\Bundle\SixBoardBundle\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;

use M6\Bundle\SixBoardBundle\Entity\Story as RealStory;
use M6\Bundle\SixBoardBundle\Entity\StoryMilestone;

/**
 * This class is needed because of the M2M with extra attributes
 */
class Story
{
    public $title;
    public $description;
    public $status;
    public $dueDate;
    public $complexity;
    public $type;
    public $milestones;
    public $tags;
    public $devUser;

    /**
     * Constructor
     *
     * @param RealStory $story The true story object
     */
    public function __construct(RealStory $story)
    {
        $this->milestones  = new ArrayCollection;

        $this->title       = $story->getTitle();
        $this->description = $story->getDescription();
        $this->status      = $story->getStatus();
        $this->dueDate     = $story->getDueDate();
        $this->complexity  = $story->getComplexity();
        $this->type        = $story->getType();
        $this->tags        = $story->getTags();
        $this->devUser     = $story->getDevUser();
        $this->story       = $story;

        foreach ($story->getStoryMilestones() as $storyMilestone) {
            $this->milestones[] = $storyMilestone->getMilestone();
        }

    }

    /**
     * Returns the updated story with correct StoryMilestone information
     * @return [type]
     */
    public function getStory()
    {

        foreach ($this->milestones as $milestone) {
            foreach ($this->story->getStoryMilestones() as $sm) {
                if ($sm->getMilestone()->getId() == $milestone->getId()) {
                    continue 2;
                }
            }

            $storyMilestone = new StoryMilestone();
            $storyMilestone->setStory($this->story);
            $storyMilestone->setMilestone($milestone);

            $this->story->addStoryMilestone($storyMilestone);
            $this->story->setTitle($this->title);
            $this->story->setDescription($this->description);
            $this->story->setStatus($this->status);
            $this->story->setDueDate($this->dueDate)
            // getter this story setTitle($this->title);
        }


        return $this->story;
    }



}
