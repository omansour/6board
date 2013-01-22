<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoteStatusChange
 *
 * @ORM\Table(name="note_status_change")
 * @ORM\Entity
 */
class NoteStatusChange
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
     * @ORM\Column(name="status_from", type="string", length=45, nullable=false)
     */
    private $statusFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="status_to", type="string", length=45, nullable=false)
     */
    private $statusTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Note
     *
     * @ORM\ManyToOne(targetEntity="Note")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="note_id", referencedColumnName="id")
     * })
     */
    private $note;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime;
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
     * Set statusFrom
     *
     * @param string $statusFrom
     * @return NoteStatusChange
     */
    public function setStatusFrom($statusFrom)
    {
        $this->statusFrom = $statusFrom;

        return $this;
    }

    /**
     * Get statusFrom
     *
     * @return string
     */
    public function getStatusFrom()
    {
        return $this->statusFrom;
    }

    /**
     * Set statusTo
     *
     * @param string $statusTo
     * @return NoteStatusChange
     */
    public function setStatusTo($statusTo)
    {
        $this->statusTo = $statusTo;

        return $this;
    }

    /**
     * Get statusTo
     *
     * @return string
     */
    public function getStatusTo()
    {
        return $this->statusTo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return NoteStatusChange
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set note
     *
     * @param \M6\Bundle\SixBoardBundle\Entity\Note $note
     * @return NoteStatusChange
     */
    public function setNote(\M6\Bundle\SixBoardBundle\Entity\Note $note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return \M6\Bundle\SixBoardBundle\Entity\Note
     */
    public function getNote()
    {
        return $this->note;
    }
}
