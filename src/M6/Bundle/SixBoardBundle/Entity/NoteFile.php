<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * M6\Bundle\SixBoardBundle\Entity\NoteFile
 *
 * @ORM\Table(name="note_file")
 * @ORM\Entity
 */
class NoteFile
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="text", nullable=false)
     */
    private $path;

    /**
     * @var Note
     *
     * @ORM\ManyToOne(targetEntity="Note")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="notes_id", referencedColumnName="id")
     * })
     */
    private $notes;



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
     * @return NoteFile
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
     * @return NoteFile
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
     * Set path
     *
     * @param string $path
     * @return NoteFile
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set notes
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Note $notes
     * @return NoteFile
     */
    public function setNotes(\M6\Bundle\SixBoardBundle\Entity\Note $notes = null)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return M6\Bundle\SixBoardBundle\Entity\Note
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
