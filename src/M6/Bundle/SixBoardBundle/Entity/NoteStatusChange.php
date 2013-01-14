<?php

namespace M6\Bundle\SixBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * M6\Bundle\SixBoardBundle\Entity\NoteStatusChange
 *
 * @ORM\Table(name="note_status_change")
 * @ORM\Entity
 */
class NoteStatusChange
{
    /**
     * @var string $statusFrom
     *
     * @ORM\Column(name="status_from", type="string", length=45, nullable=false)
     */
    private $statusFrom;

    /**
     * @var string $statusTo
     *
     * @ORM\Column(name="status_to", type="string", length=45, nullable=false)
     */
    private $statusTo;

    /**
     * @var Note
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Note")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="note_id", referencedColumnName="id")
     * })
     */
    private $note;



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
     * Set note
     *
     * @param M6\Bundle\SixBoardBundle\Entity\Note $note
     * @return NoteStatusChange
     */
    public function setNote(\M6\Bundle\SixBoardBundle\Entity\Note $note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return M6\Bundle\SixBoardBundle\Entity\Note 
     */
    public function getNote()
    {
        return $this->note;
    }
}