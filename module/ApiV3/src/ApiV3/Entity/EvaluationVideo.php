<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluationVideo
 *
 * @ORM\Table(name="evaluation_video", indexes={@ORM\Index(name="FK_evaluation_video_1", columns={"fk_evaluation_id"})})
 * @ORM\Entity
 */
class EvaluationVideo
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
     * @ORM\Column(name="video_identifier", type="string", length=100, nullable=false)
     */
    private $videoIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", nullable=false)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_uri", type="string", length=200, nullable=false, options={"default": "nothumb.png"})
     */
    private $thumbnailUri = 'nothumb.png';

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false, options={"unsigned": true})
     */
    private $duration;

    /**
     * @var \ApiV3\Entity\Evaluation
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Evaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_evaluation_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $fkEvaluation;



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
     * Set videoIdentifier
     *
     * @param string $videoIdentifier
     *
     * @return EvaluationVideo
     */
    public function setVideoIdentifier($videoIdentifier)
    {
        $this->videoIdentifier = $videoIdentifier;

        return $this;
    }

    /**
     * Get videoIdentifier
     *
     * @return string
     */
    public function getVideoIdentifier()
    {
        return $this->videoIdentifier;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return EvaluationVideo
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
     * Set thumbnailUri
     *
     * @param string $thumbnailUri
     *
     * @return EvaluationVideo
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
     * Set duration
     *
     * @param integer $duration
     *
     * @return EvaluationVideo
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
     * Set fkEvaluation
     *
     * @param \ApiV3\Entity\Evaluation $fkEvaluation
     *
     * @return EvaluationVideo
     */
    public function setFkEvaluation(\ApiV3\Entity\Evaluation $fkEvaluation = null)
    {
        $this->fkEvaluation = $fkEvaluation;

        return $this;
    }

    /**
     * Get fkEvaluation
     *
     * @return \ApiV3\Entity\Evaluation
     */
    public function getFkEvaluation()
    {
        return $this->fkEvaluation;
    }
}
