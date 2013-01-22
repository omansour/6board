<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * M6\Bundle\SixBoardBundle\Entity\Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity
 */
class Story
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime $dueDate
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var boolean $complexity
     *
     * @ORM\Column(name="complexity", type="boolean", nullable=true)
     */
    private $complexity;

    /**
     * @var string $closedFor
     *
     * @ORM\Column(name="closed_for", type="string", length=45, nullable=true)
     */
    private $closedFor;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Milestone", inversedBy="story")
     * @ORM\JoinTable(name="story_has_milestone",
     *   joinColumns={
     *     @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="milestone_id", referencedColumnName="id")
     *   }
     * )
     */
    private $milestones;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Story", inversedBy="storyFrom")
     * @ORM\JoinTable(name="story_has_story",
     *   joinColumns={
     *     @ORM\JoinColumn(name="story_id_from", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="story_id_to", referencedColumnName="id")
     *   }
     * )
     */
    private $storiesTo;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_user_id", referencedColumnName="id")
     * })
     */
    private $ownerUser;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dev_user_id", referencedColumnName="id")
     * })
     */
    private $devUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->milestones = new ArrayCollection;
        $this->storiesTo  = new ArrayCollection;
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
     * Set title
     *
     * @param string $title
     * @return Story
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Story
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
     * Set status
     *
     * @param string $status
     * @return Story
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
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Story
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
     * Set complexity
     *
     * @param boolean $complexity
     * @return Story
     */
    public function setComplexity($complexity)
    {
        $this->complexity = $complexity;

        return $this;
    }

    /**
     * Get complexity
     *
     * @return boolean
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * Set closedFor
     *
     * @param string $closedFor
     * @return Story
     */
    public function setClosedFor($closedFor)
    {
        $this->closedFor = $closedFor;

        return $this;
    }

    /**
     * Get closedFor
     *
     * @return string
     */
    public function getClosedFor()
    {
        return $this->closedFor;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Story
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Story
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add milestone
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Milestone $milestone
     * @return Story
     */
    public function addMilestone(\M6\Bundle\SixBoardBundle\Entity\Milestone $milestone)
    {
        $this->milestones[] = $milestone;

        return $this;
    }

    /**
     * Remove milestone
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Milestone $milestone
     */
    public function removeMilestone(\M6\Bundle\SixBoardBundle\Entity\Milestone $milestone)
    {
        $this->milestones->removeElement($milestone);
    }

    /**
     * Get milestone
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMilestones()
    {
        return $this->milestones;
    }

    /**
     * Add storyTo
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Story $storyTo
     * @return Story
     */
    public function addStoryTo(\M6\Bundle\SixBoardBundle\Entity\Story $storyTo)
    {
        $this->storiesTo[] = $storyTo;

        return $this;
    }

    /**
     * Remove storyTo
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Story $storyTo
     */
    public function removeStoryTo(\M6\Bundle\SixBoardBundle\Entity\Story $storyTo)
    {
        $this->storiesTo->removeElement($storyTo);
    }

    /**
     * Get storyTo
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getStoriesTo()
    {
        return $this->storiesTo;
    }

    /**
     * Set ownerUser
     *
     * @param M6\Bundle\SixBoardBundle\Entity\User $ownerUser
     * @return Story
     */
    public function setOwnerUser(\M6\Bundle\SixBoardBundle\Entity\User $ownerUser = null)
    {
        $this->ownerUser = $ownerUser;

        return $this;
    }

    /**
     * Get ownerUser
     *
     * @return M6\Bundle\SixBoardBundle\Entity\User
     */
    public function getOwnerUser()
    {
        return $this->ownerUser;
    }

    /**
     * Set devUser
     *
     * @param M6\Bundle\SixBoardBundle\Entity\User $devUser
     * @return Story
     */
    public function setDevUser(\M6\Bundle\SixBoardBundle\Entity\User $devUser = null)
    {
        $this->devUser = $devUser;

        return $this;
    }

    /**
     * Get devUser
     *
     * @return M6\Bundle\SixBoardBundle\Entity\User
     */
    public function getDevUser()
    {
        return $this->devUser;
    }
}
