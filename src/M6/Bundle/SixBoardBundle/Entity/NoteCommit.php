<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteCommit
 *
 * @ORM\Table(name="note_commit")
 * @ORM\Entity
 */
class NoteCommit
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
     * @ORM\Column(name="url", type="text", nullable=false)
     */
    private $url;

    /**
     * @var \Note
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
     * Set url
     *
     * @param string $url
     * @return NoteCommit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set notes
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Note $notes
     * @return NoteCommit
     */
    public function setNotes(\M6\Bundle\SixBoardBundle\Entity\Note $notes = null)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return \M6\Bundle\SixBoardBundle\Entity\Note
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
