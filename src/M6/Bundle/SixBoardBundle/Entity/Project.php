<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * M6\Bundle\SixBoardBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer $projectGroupId
     *
     * @ORM\Column(name="project_group_id", type="integer", nullable=true)
     */
    private $projectGroupId;



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
     * @return Project
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
     * Set projectGroupId
     *
     * @param integer $projectGroupId
     * @return Project
     */
    public function setProjectGroupId($projectGroupId)
    {
        $this->projectGroupId = $projectGroupId;

        return $this;
    }

    /**
     * Get projectGroupId
     *
     * @return integer
     */
    public function getProjectGroupId()
    {
        return $this->projectGroupId;
    }
}
