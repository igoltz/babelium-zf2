<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media", uniqueConstraints={@ORM\UniqueConstraint(name="code_UNIQUE", columns={"mediacode"})}, indexes={@ORM\Index(name="fk_media_1", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class Media
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
     * @ORM\Column(name="mediacode", type="string", length=45, nullable=false)
     */
    private $mediacode;

    /**
     * @var integer
     *
     * @ORM\Column(name="instanceid", type="integer", nullable=false, options={"unsigned": true})
     */
    private $instanceid;

    /**
     * @var string
     *
     * @ORM\Column(name="component", type="string", length=45, nullable=false)
     */
    private $component;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=false, options={"default": "video"})
     */
    private $type = 'video';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="integer", nullable=false, options={"default": 0})
     */
    private $timecreated = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="integer", nullable=false, options={"default": 0})
     */
    private $timemodified = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false, options={"default": 0, "unsigned": true})
     */
    private $duration = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="level", type="boolean", nullable=false, options={"default": 0, "comment": "0: undefined, 1: primary, 2: model, 3: attempt, 4: raw"})
     */
    private $level = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_converted", type="boolean", nullable=false, options={"default": 0})
     */
    private $isConverted;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_processed", type="boolean", nullable=false, options={"default": 0})
     */
    private $isProcessed;

    /**
     * @var integer
     *
     * @ORM\Column(name="defaultthumbnail", type="integer", nullable=true, options={"default": 1})
     */
    private $defaultthumbnail = '1';

    /**
     * @var \ApiV3\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $fkUser;



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
     * Set mediacode
     *
     * @param string $mediacode
     *
     * @return Media
     */
    public function setMediacode($mediacode)
    {
        $this->mediacode = $mediacode;

        return $this;
    }

    /**
     * Get mediacode
     *
     * @return string
     */
    public function getMediacode()
    {
        return $this->mediacode;
    }

    /**
     * Set instanceid
     *
     * @param integer $instanceid
     *
     * @return Media
     */
    public function setInstanceid($instanceid)
    {
        $this->instanceid = $instanceid;

        return $this;
    }

    /**
     * Get instanceid
     *
     * @return integer
     */
    public function getInstanceid()
    {
        return $this->instanceid;
    }

    /**
     * Set component
     *
     * @param string $component
     *
     * @return Media
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return string
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Media
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
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return Media
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
     * @return Media
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
     * Set duration
     *
     * @param integer $duration
     *
     * @return Media
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set level
     *
     * @param boolean $level
     *
     * @return Media
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return boolean
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set defaultthumbnail
     *
     * @param integer $defaultthumbnail
     *
     * @return Media
     */
    public function setDefaultthumbnail($defaultthumbnail)
    {
        $this->defaultthumbnail = $defaultthumbnail;

        return $this;
    }

    /**
     * Get defaultthumbnail
     *
     * @return integer
     */
    public function getDefaultthumbnail()
    {
        return $this->defaultthumbnail;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Media
     */
    public function setFkUser(\ApiV3\Entity\User $fkUser = null)
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    /**
     * Get fkUser
     *
     * @return \ApiV3\Entity\User
     */
    public function getFkUser()
    {
        return $this->fkUser;
    }

    /**
     * Set isConverted
     *
     * @param boolean $isConverted
     *
     * @return Media
     */
    public function setIsConverted($isConverted)
    {
        $this->isConverted = $isConverted;

        return $this;
    }

    /**
     * Get isConverted
     *
     * @return boolean
     */
    public function getIsConverted()
    {
        return $this->isConverted;
    }

    /**
     * Set isProcessed
     *
     * @param boolean $isProcessed
     *
     * @return Media
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed;

        return $this;
    }

    /**
     * Get isProcessed
     *
     * @return boolean
     */
    public function getIsProcessed()
    {
        return $this->isProcessed;
    }
}
