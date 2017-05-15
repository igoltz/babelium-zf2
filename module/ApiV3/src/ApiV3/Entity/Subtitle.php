<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subtitle
 *
 * @ORM\Table(name="subtitle", indexes={@ORM\Index(name="FK_exercise_subtitle_2", columns={"fk_user_id"}), @ORM\Index(name="fk_subtitle_media_idx", columns={"fk_media_id"})})
 * @ORM\Entity
 */
class Subtitle
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
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=45, nullable=false)
     */
    private $language;

    /**
     * @var boolean
     *
     * @ORM\Column(name="translation", type="boolean", nullable=false)
     */
    private $translation = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="integer", nullable=false)
     */
    private $timecreated = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="complete", type="boolean", nullable=false)
     */
    private $complete = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="serialized_subtitles", type="text", nullable=false)
     */
    private $serializedSubtitles;

    /**
     * @var integer
     *
     * @ORM\Column(name="subtitle_count", type="integer", nullable=false)
     */
    private $subtitleCount;

    /**
     * @var \ApiV3\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user_id", referencedColumnName="id")
     * })
     */
    private $fkUser;

    /**
     * @var \ApiV3\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_media_id", referencedColumnName="id")
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
     * Set language
     *
     * @param string $language
     *
     * @return Subtitle
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set translation
     *
     * @param boolean $translation
     *
     * @return Subtitle
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return boolean
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return Subtitle
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
     * Set complete
     *
     * @param boolean $complete
     *
     * @return Subtitle
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set serializedSubtitles
     *
     * @param string $serializedSubtitles
     *
     * @return Subtitle
     */
    public function setSerializedSubtitles($serializedSubtitles)
    {
        $this->serializedSubtitles = $serializedSubtitles;

        return $this;
    }

    /**
     * Get serializedSubtitles
     *
     * @return string
     */
    public function getSerializedSubtitles()
    {
        return $this->serializedSubtitles;
    }

    /**
     * Set subtitleCount
     *
     * @param integer $subtitleCount
     *
     * @return Subtitle
     */
    public function setSubtitleCount($subtitleCount)
    {
        $this->subtitleCount = $subtitleCount;

        return $this;
    }

    /**
     * Get subtitleCount
     *
     * @return integer
     */
    public function getSubtitleCount()
    {
        return $this->subtitleCount;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Subtitle
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
     * Set fkMedia
     *
     * @param \ApiV3\Entity\Media $fkMedia
     *
     * @return Subtitle
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
