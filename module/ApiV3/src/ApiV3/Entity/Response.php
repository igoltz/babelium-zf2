<?php

namespace ApiV3\Entity;

use JMS\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * Response
 *
 * @ORM\Table(name="response", uniqueConstraints={@ORM\UniqueConstraint(name="fileidentifier_UNIQUE", columns={"file_identifier"})}, indexes={@ORM\Index(name="FK_response_1", columns={"fk_user_id"}), @ORM\Index(name="FK_response_2", columns={"fk_exercise_id"}), @ORM\Index(name="fk_response_transcriptions1", columns={"fk_transcription_id"}), @ORM\Index(name="FK_response_3", columns={"fk_subtitle_id"})})
 * @ORM\Entity(repositoryClass="ApiV3\Entity\Repository\ResponseRepository")
 */
class Response
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"details"})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_user_id", type="integer", nullable=false)
     */
    private $fkUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_media_id", type="integer", nullable=true)
     */
    private $fkMediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="file_identifier", type="string", length=100, nullable=false)
     * @Groups({"details"})
     */
    private $fileIdentifier;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_private", type="boolean", nullable=false)
     * @Groups({"details"})
     */
    private $isPrivate;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_uri", type="string", length=200, nullable=false)
     * @Groups({"details"})
     */
    private $thumbnailUri = 'nothumb.png';

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", nullable=false)
     * @Groups({"details"})
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     * @Groups({"details"})
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adding_date", type="datetime", nullable=false)
     * @Groups({"details"})
     */
    private $addingDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating_amount", type="integer", nullable=false)
     * @Groups({"details"})
     */
    private $ratingAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="character_name", type="string", length=45, nullable=false)
     * @Groups({"details"})
     */
    private $characterName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="priority_date", type="datetime", nullable=false)
     * @Groups({"details"})
     */
    private $priorityDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \ApiV3\Entity\Exercise
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Exercise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_exercise_id", referencedColumnName="id")
     * })
     */
    private $fkExercise;

    /**
     * @var \ApiV3\Entity\Subtitle
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Subtitle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_subtitle_id", referencedColumnName="id")
     * })
     */
    private $fkSubtitle;

    /**
     * @var \ApiV3\Entity\Transcription
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Transcription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_transcription_id", referencedColumnName="id")
     * })
     */
    private $fkTranscription;



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
     * Set fkUserId
     *
     * @param integer $fkUserId
     *
     * @return Response
     */
    public function setFkUserId($fkUserId)
    {
        $this->fkUserId = $fkUserId;

        return $this;
    }

    /**
     * Get fkUserId
     *
     * @return integer
     */
    public function getFkUserId()
    {
        return $this->fkUserId;
    }

    /**
     * Set fkMediaId
     *
     * @param integer $fkMediaId
     *
     * @return Response
     */
    public function setFkMediaId($fkMediaId)
    {
        $this->fkMediaId = $fkMediaId;

        return $this;
    }

    /**
     * Get fkMediaId
     *
     * @return integer
     */
    public function getFkMediaId()
    {
        return $this->fkMediaId;
    }

    /**
     * Set fileIdentifier
     *
     * @param string $fileIdentifier
     *
     * @return Response
     */
    public function setFileIdentifier($fileIdentifier)
    {
        $this->fileIdentifier = $fileIdentifier;

        return $this;
    }

    /**
     * Get fileIdentifier
     *
     * @return string
     */
    public function getFileIdentifier()
    {
        return $this->fileIdentifier;
    }

    /**
     * Set isPrivate
     *
     * @param boolean $isPrivate
     *
     * @return Response
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    /**
     * Get isPrivate
     *
     * @return boolean
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * Set thumbnailUri
     *
     * @param string $thumbnailUri
     *
     * @return Response
     */
    public function setThumbnailUri($thumbnailUri)
    {
        $this->thumbnailUri = $thumbnailUri;

        return $this;
    }

    /**
     * Get thumbnailUri
     *
     * @return string
     */
    public function getThumbnailUri()
    {
        return $this->thumbnailUri;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return Response
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Response
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
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return Response
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
     * Set ratingAmount
     *
     * @param integer $ratingAmount
     *
     * @return Response
     */
    public function setRatingAmount($ratingAmount)
    {
        $this->ratingAmount = $ratingAmount;

        return $this;
    }

    /**
     * Get ratingAmount
     *
     * @return integer
     */
    public function getRatingAmount()
    {
        return $this->ratingAmount;
    }

    /**
     * Set characterName
     *
     * @param string $characterName
     *
     * @return Response
     */
    public function setCharacterName($characterName)
    {
        $this->characterName = $characterName;

        return $this;
    }

    /**
     * Get characterName
     *
     * @return string
     */
    public function getCharacterName()
    {
        return $this->characterName;
    }

    /**
     * Set priorityDate
     *
     * @param \DateTime $priorityDate
     *
     * @return Response
     */
    public function setPriorityDate($priorityDate)
    {
        $this->priorityDate = $priorityDate;

        return $this;
    }

    /**
     * Get priorityDate
     *
     * @return \DateTime
     */
    public function getPriorityDate()
    {
        return $this->priorityDate;
    }

    /**
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return Response
     */
    public function setFkExercise(\ApiV3\Entity\Exercise $fkExercise = null)
    {
        $this->fkExercise = $fkExercise;

        return $this;
    }

    /**
     * Get fkExercise
     *
     * @return \ApiV3\Entity\Exercise
     */
    public function getFkExercise()
    {
        return $this->fkExercise;
    }

    /**
     * Set fkSubtitle
     *
     * @param \ApiV3\Entity\Subtitle $fkSubtitle
     *
     * @return Response
     */
    public function setFkSubtitle(\ApiV3\Entity\Subtitle $fkSubtitle = null)
    {
        $this->fkSubtitle = $fkSubtitle;

        return $this;
    }

    /**
     * Get fkSubtitle
     *
     * @return \ApiV3\Entity\Subtitle
     */
    public function getFkSubtitle()
    {
        return $this->fkSubtitle;
    }

    /**
     * Set fkTranscription
     *
     * @param \ApiV3\Entity\Transcription $fkTranscription
     *
     * @return Response
     */
    public function setFkTranscription(\ApiV3\Entity\Transcription $fkTranscription = null)
    {
        $this->fkTranscription = $fkTranscription;

        return $this;
    }

    /**
     * Get fkTranscription
     *
     * @return \ApiV3\Entity\Transcription
     */
    public function getFkTranscription()
    {
        return $this->fkTranscription;
    }
}
