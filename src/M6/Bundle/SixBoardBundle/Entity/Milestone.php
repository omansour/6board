<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * M6\Bundle\SixBoardBundle\Entity\Milestone
 *
 * @ORM\Table(name="milestone")
 * @ORM\Entity
 */
class Milestone
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime $dueDate
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Story", mappedBy="milestone")
     */
    private $story;

    /**
     * @var Project
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
        $this->story = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $name
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
     * @param string $description
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
     * @param \DateTime $dueDate
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
     * @param string $status
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
     * Add story
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Story $story
     * @return Milestone
     */
    public function addStory(\M6\Bundle\SixBoardBundle\Entity\Story $story)
    {
        $this->story[] = $story;
    
        return $this;
    }

    /**
     * Remove story
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Story $story
     */
    public function removeStory(\M6\Bundle\SixBoardBundle\Entity\Story $story)
    {
        $this->story->removeElement($story);
    }

    /**
     * Get story
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set project
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Project $project
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
     * @return M6\Bundle\SixBoardBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}