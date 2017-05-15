<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transcription
 *
 * @ORM\Table(name="transcription")
 * @ORM\Entity
 */
class Transcription
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adding_date", type="datetime", nullable=false)
     */
    private $addingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="transcription", type="text", length=65535, nullable=true)
     */
    private $transcription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transcription_date", type="datetime", nullable=true)
     */
    private $transcriptionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="system", type="string", length=45, nullable=false)
     */
    private $system;



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
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return Transcription
     */
    public function setAddingDate($addingDate)
    {
        $this->addingDate = $addingDate;

        return $this;
    }

    /**
     * Get addingDate
     *
     * @return \DateTime
     */
    public function getAddingDate()
    {
        return $this->addingDate;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Transcription
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
     * Set transcription
     *
     * @param string $transcription
     *
     * @return Transcription
     */
    public function setTranscription($transcription)
    {
        $this->transcription = $transcription;

        return $this;
    }

    /**
     * Get transcription
     *
     * @return string
     */
    public function getTranscription()
    {
        return $this->transcription;
    }

    /**
     * Set transcriptionDate
     *
     * @param \DateTime $transcriptionDate
     *
     * @return Transcription
     */
    public function setTranscriptionDate($transcriptionDate)
    {
        $this->transcriptionDate = $transcriptionDate;

        return $this;
    }

    /**
     * Get transcriptionDate
     *
     * @return \DateTime
     */
    public function getTranscriptionDate()
    {
        return $this->transcriptionDate;
    }

    /**
     * Set system
     *
     * @param string $system
     *
     * @return Transcription
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
    }
}
