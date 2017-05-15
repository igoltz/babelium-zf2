<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation", indexes={@ORM\Index(name="FK_evaluation_1", columns={"fk_response_id"}), @ORM\Index(name="FK_evaluation_2", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class Evaluation
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
     * @var boolean
     *
     * @ORM\Column(name="score_overall", type="boolean", nullable=true)
     */
    private $scoreOverall = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="adding_date", type="datetime", nullable=true)
     */
    private $addingDate = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_intonation", type="boolean", nullable=true)
     */
    private $scoreIntonation = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_fluency", type="boolean", nullable=true)
     */
    private $scoreFluency = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_rhythm", type="boolean", nullable=true)
     */
    private $scoreRhythm = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_spontaneity", type="boolean", nullable=true)
     */
    private $scoreSpontaneity = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_comprehensibility", type="boolean", nullable=true)
     */
    private $scoreComprehensibility = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_pronunciation", type="boolean", nullable=true)
     */
    private $scorePronunciation = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_adequacy", type="boolean", nullable=true)
     */
    private $scoreAdequacy = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_range", type="boolean", nullable=true)
     */
    private $scoreRange = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score_accuracy", type="boolean", nullable=true)
     */
    private $scoreAccuracy = '0';

    /**
     * @var \ApiV3\Entity\Response
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Response")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_response_id", referencedColumnName="id")
     * })
     */
    private $fkResponse;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set scoreOverall
     *
     * @param boolean $scoreOverall
     *
     * @return Evaluation
     */
    public function setScoreOverall($scoreOverall)
    {
        $this->scoreOverall = $scoreOverall;

        return $this;
    }

    /**
     * Get scoreOverall
     *
     * @return boolean
     */
    public function getScoreOverall()
    {
        return $this->scoreOverall;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Evaluation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return Evaluation
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
     * Set scoreIntonation
     *
     * @param boolean $scoreIntonation
     *
     * @return Evaluation
     */
    public function setScoreIntonation($scoreIntonation)
    {
        $this->scoreIntonation = $scoreIntonation;

        return $this;
    }

    /**
     * Get scoreIntonation
     *
     * @return boolean
     */
    public function getScoreIntonation()
    {
        return $this->scoreIntonation;
    }

    /**
     * Set scoreFluency
     *
     * @param boolean $scoreFluency
     *
     * @return Evaluation
     */
    public function setScoreFluency($scoreFluency)
    {
        $this->scoreFluency = $scoreFluency;

        return $this;
    }

    /**
     * Get scoreFluency
     *
     * @return boolean
     */
    public function getScoreFluency()
    {
        return $this->scoreFluency;
    }

    /**
     * Set scoreRhythm
     *
     * @param boolean $scoreRhythm
     *
     * @return Evaluation
     */
    public function setScoreRhythm($scoreRhythm)
    {
        $this->scoreRhythm = $scoreRhythm;

        return $this;
    }

    /**
     * Get scoreRhythm
     *
     * @return boolean
     */
    public function getScoreRhythm()
    {
        return $this->scoreRhythm;
    }

    /**
     * Set scoreSpontaneity
     *
     * @param boolean $scoreSpontaneity
     *
     * @return Evaluation
     */
    public function setScoreSpontaneity($scoreSpontaneity)
    {
        $this->scoreSpontaneity = $scoreSpontaneity;

        return $this;
    }

    /**
     * Get scoreSpontaneity
     *
     * @return boolean
     */
    public function getScoreSpontaneity()
    {
        return $this->scoreSpontaneity;
    }

    /**
     * Set scoreComprehensibility
     *
     * @param boolean $scoreComprehensibility
     *
     * @return Evaluation
     */
    public function setScoreComprehensibility($scoreComprehensibility)
    {
        $this->scoreComprehensibility = $scoreComprehensibility;

        return $this;
    }

    /**
     * Get scoreComprehensibility
     *
     * @return boolean
     */
    public function getScoreComprehensibility()
    {
        return $this->scoreComprehensibility;
    }

    /**
     * Set scorePronunciation
     *
     * @param boolean $scorePronunciation
     *
     * @return Evaluation
     */
    public function setScorePronunciation($scorePronunciation)
    {
        $this->scorePronunciation = $scorePronunciation;

        return $this;
    }

    /**
     * Get scorePronunciation
     *
     * @return boolean
     */
    public function getScorePronunciation()
    {
        return $this->scorePronunciation;
    }

    /**
     * Set scoreAdequacy
     *
     * @param boolean $scoreAdequacy
     *
     * @return Evaluation
     */
    public function setScoreAdequacy($scoreAdequacy)
    {
        $this->scoreAdequacy = $scoreAdequacy;

        return $this;
    }

    /**
     * Get scoreAdequacy
     *
     * @return boolean
     */
    public function getScoreAdequacy()
    {
        return $this->scoreAdequacy;
    }

    /**
     * Set scoreRange
     *
     * @param boolean $scoreRange
     *
     * @return Evaluation
     */
    public function setScoreRange($scoreRange)
    {
        $this->scoreRange = $scoreRange;

        return $this;
    }

    /**
     * Get scoreRange
     *
     * @return boolean
     */
    public function getScoreRange()
    {
        return $this->scoreRange;
    }

    /**
     * Set scoreAccuracy
     *
     * @param boolean $scoreAccuracy
     *
     * @return Evaluation
     */
    public function setScoreAccuracy($scoreAccuracy)
    {
        $this->scoreAccuracy = $scoreAccuracy;

        return $this;
    }

    /**
     * Get scoreAccuracy
     *
     * @return boolean
     */
    public function getScoreAccuracy()
    {
        return $this->scoreAccuracy;
    }

    /**
     * Set fkResponse
     *
     * @param \ApiV3\Entity\Response $fkResponse
     *
     * @return Evaluation
     */
    public function setFkResponse(\ApiV3\Entity\Response $fkResponse = null)
    {
        $this->fkResponse = $fkResponse;

        return $this;
    }

    /**
     * Get fkResponse
     *
     * @return \ApiV3\Entity\Response
     */
    public function getFkResponse()
    {
        return $this->fkResponse;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Evaluation
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
}
