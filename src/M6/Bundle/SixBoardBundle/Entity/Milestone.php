<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Milestone
 *
 * @ORM\Table(name="milestone")
 * @ORM\Entity
 */
class Milestone
{
    const STATUS_CLOSED = 0;
    const STATUS_OPEN   = 1;

    public static $statuses = array(
        self::STATUS_CLOSED => "Closed",
        self::STATUS_OPEN   => "Open",
    );

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Milestone", inversedBy="attachedMilestones")
     * @ORM\JoinTable(name="milestone_has_autoaddmilestone",
     *   joinColumns={
     *     @ORM\JoinColumn(name="milestone_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="milestone_id1", referencedColumnName="id")
     *   }
     * )
     */
    private $milestones;

    /**
     * @ORM\ManyToMany(targetEntity="Milestone", mappedBy="milestones")
     **/
    private $attachedMilestones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="StoryMilestone", mappedBy="milestone", cascade={"ALL"}, orphanRemoval=true)
     * @ORM\OrderBy({"rank" = "ASC"})
     */
    private $stories;

    /**
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
     */
    private $project;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attachedMilestones = new ArrayCollection;
        $this->milestones         = new ArrayCollection;
        $this->stories            = new ArrayCollection;
    }

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
     * Set name
     *
     * @param  string    $name
     * @return Milestone
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param  string    $description
     * @return Milestone
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dueDate
     *
     * @param  \DateTime $dueDate
     * @return Milestone
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set status
     *
     * @param  string    $status
     * @return Milestone
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add milestones
     *
     * @param  \M6\Bundle\SixBoardBundle\Entity\Milestone $milestones
     * @return Milestone
     */
    public function addMilestone(\M6\Bundle\SixBoardBundle\Entity\Milestone $milestones)
    {
        $this->milestones[] = $milestones;

        return $this;
    }

    /**
     * Remove milestones
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Milestone $milestones
     */
    public function removeMilestone(\M6\Bundle\SixBoardBundle\Entity\Milestone $milestones)
    {
        $this->milestones->removeElement($milestones);
    }

    /**
     * Get milestones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMilestones()
    {
        return $this->milestones;
    }

    /**
     * Set project
     *
     * @param  \M6\Bundle\SixBoardBundle\Entity\Project $project
     * @return Milestone
     */
    public function setProject(\M6\Bundle\SixBoardBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \M6\Bundle\SixBoardBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * __toString function
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName() .' ('. $this->getProject() .')';
    }

    public function getStories()
    {
        return $this->stories;
    }

    public function addStory(Story $story)
    {

        $exists = $this->getStories()->exists(function($key, $s) use ($story) {
            return $s->getStory()->getId() === $story->getId();
        });

        if (!$exists) {
            $sm = new StoryMilestone();

            $sm->setMilestone($this);
            $sm->setStory($story);

            $this->stories->add($sm);
        }

        return $this;
    }

    public function removeStory(Story $story)
    {
        $found = $this->getStories()->filter(function($s) use ($story) {
            return $story->getId() === $s->getId();
        });

        if (count($found)) {
            $this->getStories()->removeElement($found->first());
        }

        return $this;
    }

    public function getAttachedMilestones()
    {
        return $this->attachedMilestones;
    }

    public function setAttachedMilestones($attachedMilestones)
    {
        $this->attachedMilestones = $attachedMilestones;
    }
}
