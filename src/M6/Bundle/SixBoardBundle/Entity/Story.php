<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity(repositoryClass="StoryRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Story
{
    const STATUS_CLOSED      = 0;
    const STATUS_NEW         = 1;
    const STATUS_VALID       = 2;
    const STATUS_IN_PROGRESS = 3;

    const CLOSED_FOR_RESOLVED         = 1;
    const CLOSED_FOR_INVALID          = 2;
    const CLOSED_FOR_WONT_BE_RESOLVED = 3;
    const CLOSED_FOR_UNREPRODUCIBLE   = 4;
    const CLOSED_FOR_DUPLICATE        = 5;

    const TYPE_MAJOR   = 1;
    const TYPE_MINOR   = 2;
    const TYPE_ALERT   = 3;
    const TYPE_FEATURE = 4;

    public static $statuses = array(
        self::STATUS_NEW         => "New",
        self::STATUS_VALID       => "Valid",
        self::STATUS_IN_PROGRESS => "In progress",
        self::STATUS_CLOSED      => "Closed",
    );

    public static $types = array(
        self::TYPE_FEATURE => "Feature",
        self::TYPE_MINOR   => "Minor",
        self::TYPE_MAJOR   => "Major",
        self::TYPE_ALERT   => "Alert",
    );

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var smallint
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     * @Gedmo\Versioned
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="date", nullable=true)
     */
    private $dueDate;

    /**
     * @var smallint
     *
     * @ORM\Column(name="complexity", type="smallint", nullable=true)
     */
    private $complexity;

    /**
     * @var string
     *
     * @ORM\Column(name="closed_for", type="string", length=255, nullable=true)
     */
    private $closedFor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var smallint
     *
     * @ORM\Column(name="type", type="smallint", nullable=false)
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="StoryMilestone", mappedBy="story", cascade={"ALL"}, orphanRemoval=true)
     */
    private $storyMilestones;

    private $milestones;
    private $previousStoryMilestones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Story", inversedBy="fromStories")
     * @ORM\JoinTable(name="story_has_story",
     *   joinColumns={
     *     @ORM\JoinColumn(name="story_id_from", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="story_id_to", referencedColumnName="id")
     *   }
     * )
     */
    private $toStories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Story", mappedBy="toStories")
     */
    private $fromStories;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="stories", cascade={"persist"})
     * @ORM\JoinTable(name="story_has_tag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tags;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_user_id", referencedColumnName="id")
     * })
     * @Gedmo\Blameable(on="create")
     */
    private $ownerUser;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dev_user_id", referencedColumnName="id")
     * })
     */
    private $devUser;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="story")
     */
    private $notes;

    private $user;

    /**
     * Constructor
     */
    public function __construct($user = null)
    {
        $this->storyMilestones = new ArrayCollection;
        $this->milestones      = new ArrayCollection;
        $this->toStories       = new ArrayCollection;
        $this->tags            = new ArrayCollection;
        $this->fromStories     = new ArrayCollection;
        $this->user            = $user;
        $this->status          = self::STATUS_NEW;
    }

    /**
     * @ORM\PrePersist
     */
    public function attacheMilestones()
    {
        $milestones = $this->getMilestones();

        foreach ($milestones as $m) {

            $attachedMilstones = $m->getMilestones();

            foreach ($attachedMilstones as $am) {

                $sam = new StoryMilestone();

                $sam->setStory($this);
                $sam->setMilestone($am);

                $this->addStoryMilestone($sam);
            }
        }
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
     * @param  string $title
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
     * @param  string $description
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
     * @param  string $status
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
     * @param  \DateTime $dueDate
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
     * @param  boolean $complexity
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
     * @param  string $closedFor
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
     * @param  \DateTime $createdAt
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
     * @param  \DateTime $updatedAt
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
     * Set type
     *
     * @param  string $type
     * @return Story
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add toStories
     *
     * @param  \M6\Bundle\SixBoardBundle\Entity\Story $toStory
     * @return Story
     */
    public function addToStory(\M6\Bundle\SixBoardBundle\Entity\Story $toStory)
    {
        $this->toStories[] = $toStories;

        return $this;
    }

    /**
     * Remove toStories
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Story $toStory
     */
    public function removeToStory(\M6\Bundle\SixBoardBundle\Entity\Story $toStory)
    {
        $this->toStories->removeElement($toStories);
    }

    /**
     * Get toStories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToStories()
    {
        return $this->toStories;
    }

    /**
     * Add tags
     *
     * @param  \M6\Bundle\SixBoardBundle\Entity\Tag $tags
     * @return Story
     */
    public function addTag(\M6\Bundle\SixBoardBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Tag $tags
     */
    public function removeTag(\M6\Bundle\SixBoardBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set ownerUser
     *
     * @param  \Application\Sonata\UserBundle\Entity\User $ownerUser
     * @return Story
     */
    public function setOwnerUser(\Application\Sonata\UserBundle\Entity\User $ownerUser = null)
    {
        $this->ownerUser = $ownerUser;

        return $this;
    }

    /**
     * Get ownerUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getOwnerUser()
    {
        return $this->ownerUser;
    }

    /**
     * Set devUser
     *
     * @param  \Application\Sonata\UserBundle\Entity\User $devUser
     * @return Story
     */
    public function setDevUser(\Application\Sonata\UserBundle\Entity\User $devUser = null)
    {
        $this->devUser = $devUser;

        return $this;
    }

    /**
     * Get devUser
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getDevUser()
    {
        return $this->devUser;
    }

    /**
     * getFromStories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFromStories()
    {
        return $this->fromStories;
    }

    /**
     * setFromStories
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Story $fromStories
     */
    public function setFromStories($fromStories)
    {
        $this->fromStories = $fromStories;
    }

    public function getStoryMilestones()
    {
        return $this->storyMilestones;
    }

    public function addStoryMilestone(StoryMilestone $sm)
    {
        $this->storyMilestones->add($sm);
    }

    public function removeStoryMilestone(StoryMilestone $m)
    {
        $this->storyMilestones->removeElement($m);
    }

    public function getMilestones()
    {
        $milestones = new ArrayCollection();

        foreach ($this->storyMilestones as $sm) {
            $milestones[] = $sm->getMilestone();
        }

        return $milestones;
    }

    public function setMilestones($milestones)
    {
        if (is_a($milestones, "M6\Bundle\SixBoardBundle\Entity\Milestone")) {
            $milestones = new ArrayCollection(array($milestones));
        }

        foreach ($this->getStoryMilestones() as $sm) {
            $temp[$sm->getMilestone()->getId()] = array(
                'rank' => $sm->getRank(),
                'prioritized' => $sm->isPrioritized()
            );
        }

        $this->getStoryMilestones()->clear();

        // on parcrours toutes les milestones detectées sur la story
        foreach ($milestones as $m) {

            $sm = new StoryMilestone();

            $sm->setStory($this);
            $sm->setMilestone($m);

            if (array_key_exists($m->getId(), $temp)) {
                $sm->setRank($temp[$m->getId()]['rank']);
                $sm->setPrioritized($temp[$m->getId()]['prioritized']);
            }

            $this->addStoryMilestone($sm);
        }
    }

    public function __toString()
    {
        return (string) '('. $this->getId() .')'.$this->getTitle();
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes()
    {
        $this->notes = $notes;
    }

    public function getReadableStatus()
    {
        return self::$statuses[$this->getStatus()];
    }

    public function getReadableTypes()
    {
        return self::$types[$this->getType()];
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPreviousStoryMilestones($previousSM)
    {
        $this->previousStoryMilestones = $previousSM;
    }

    public function getPreviousStoryMilestones()
    {
        return $this->previousStoryMilestones;
    }
}
