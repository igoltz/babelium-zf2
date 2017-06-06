<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaRendition
 *
 * @ORM\Table(name="media_rendition", indexes={@ORM\Index(name="FK_media_rendition_1", columns={"fk_media_id"})})
 * @ORM\Entity
 */
class MediaRendition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="contenthash", type="string", length=40, nullable=false)
     */
    private $contenthash;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false, options={"default": 0, "comment": "0: raw 1: encoding, 2: ready, 3: duplicate, 4: error"})
     */
    private $status = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="integer", nullable=false)
     */
    private $timecreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="integer", nullable=false)
     */
    private $timemodified;

    /**
     * @var integer
     *
     * @ORM\Column(name="filesize", type="integer", nullable=false, options={"default": 0})
     */
    private $filesize = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="metadata", type="text", length=65535, nullable=true)
     */
    private $metadata;

    /**
     * @var integer
     *
     * @ORM\Column(name="dimension", type="integer", nullable=true)
     */
    private $dimension;

    /**
     * @var \ApiV3\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_media_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $fkMedia;



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
     * Set filename
     *
     * @param string $filename
     *
     * @return MediaRendition
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set contenthash
     *
     * @param string $contenthash
     *
     * @return MediaRendition
     */
    public function setContenthash($contenthash)
    {
        $this->contenthash = $contenthash;

        return $this;
    }

    /**
     * Get contenthash
     *
     * @return string
     */
    public function getContenthash()
    {
        return $this->contenthash;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return MediaRendition
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return MediaRendition
     */
    public function setTimecreated($timecreated)
    {
        $this->timecreated = $timecreated;

        return $this;
    }

    /**
     * Get timecreated
     *
     * @return integer
     */
    public function getTimecreated()
    {
        return $this->timecreated;
    }

    /**
     * Set timemodified
     *
     * @param integer $timemodified
     *
     * @return MediaRendition
     */
    public function setTimemodified($timemodified)
    {
        $this->timemodified = $timemodified;

        return $this;
    }

    /**
     * Get timemodified
     *
     * @return integer
     */
    public function getTimemodified()
    {
        return $this->timemodified;
    }

    /**
     * Set filesize
     *
     * @param integer $filesize
     *
     * @return MediaRendition
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return integer
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set metadata
     *
     * @param string $metadata
     *
     * @return MediaRendition
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set dimension
     *
     * @param integer $dimension
     *
     * @return MediaRendition
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return integer
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set fkMedia
     *
     * @param \ApiV3\Entity\Media $fkMedia
     *
     * @return MediaRendition
     */
    public function setFkMedia(\ApiV3\Entity\Media $fkMedia = null)
    {
        $this->fkMedia = $fkMedia;

        return $this;
    }

    /**
     * Get fkMedia
     *
     * @return \ApiV3\Entity\Media
     */
    public function getFkMedia()
    {
        return $this->fkMedia;
    }
}
