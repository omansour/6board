<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity
 */
class Tag
{
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Story", mappedBy="tags")
     */
    private $stories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stories = new ArrayCollection;
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
     * @return Tag
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
     * Add story
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Story $stories
     * @return Tag
     */
    public function addStory(\M6\Bundle\SixBoardBundle\Entity\Story $story)
    {
        $this->stories[] = $stories;

        return $this;
    }

    /**
     * Remove story
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Story $story
     */
    public function removeStory(\M6\Bundle\SixBoardBundle\Entity\Story $story)
    {
        $this->stories->removeElement($stories);
    }

    /**
     * Get stories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * __toString function
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
