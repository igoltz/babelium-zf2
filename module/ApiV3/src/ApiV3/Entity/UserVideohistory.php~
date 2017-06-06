<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserVideohistory
 *
 * @ORM\Table(name="user_videohistory", indexes={@ORM\Index(name="FK_user_videohistory_1", columns={"fk_user_id"}), @ORM\Index(name="FK_user_videohistory_2", columns={"fk_user_session_id"}), @ORM\Index(name="FK_user_videohistory_3", columns={"fk_exercise_id"}), @ORM\Index(name="FK_user_videohistory_4", columns={"fk_response_id"}), @ORM\Index(name="FK_user_videohistory_5", columns={"fk_subtitle_id"})})
 * @ORM\Entity
 */
class UserVideohistory
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
     * @var boolean
     *
     * @ORM\Column(name="response_attempt", type="boolean", nullable=false, options={"default": 0})
     */
    private $responseAttempt = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="incidence_date", type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $incidenceDate = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="subtitles_are_used", type="boolean", nullable=false, options={"default": 0})
     */
    private $subtitlesAreUsed = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="response_role", type="string", length=45, nullable=true)
     */
    private $responseRole;

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
     * @var \ApiV3\Entity\UserSession
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\UserSession")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user_session_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $fkUserSession;

    /**
     * @var \ApiV3\Entity\Exercise
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Exercise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_exercise_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $fkExercise;

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
     * @var \ApiV3\Entity\Subtitle
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Subtitle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_subtitle_id", referencedColumnName="id")
     * })
     */
    private $fkSubtitle;



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
     * Set responseAttempt
     *
     * @param boolean $responseAttempt
     *
     * @return UserVideohistory
     */
    public function setResponseAttempt($responseAttempt)
    {
        $this->responseAttempt = $responseAttempt;

        return $this;
    }

    /**
     * Get responseAttempt
     *
     * @return boolean
     */
    public function getResponseAttempt()
    {
        return $this->responseAttempt;
    }

    /**
     * Set incidenceDate
     *
     * @param \DateTime $incidenceDate
     *
     * @return UserVideohistory
     */
    public function setIncidenceDate($incidenceDate)
    {
        $this->incidenceDate = $incidenceDate;

        return $this;
    }

    /**
     * Get incidenceDate
     *
     * @return \DateTime
     */
    public function getIncidenceDate()
    {
        return $this->incidenceDate;
    }

    /**
     * Set subtitlesAreUsed
     *
     * @param boolean $subtitlesAreUsed
     *
     * @return UserVideohistory
     */
    public function setSubtitlesAreUsed($subtitlesAreUsed)
    {
        $this->subtitlesAreUsed = $subtitlesAreUsed;

        return $this;
    }

    /**
     * Get subtitlesAreUsed
     *
     * @return boolean
     */
    public function getSubtitlesAreUsed()
    {
        return $this->subtitlesAreUsed;
    }

    /**
     * Set responseRole
     *
     * @param string $responseRole
     *
     * @return UserVideohistory
     */
    public function setResponseRole($responseRole)
    {
        $this->responseRole = $responseRole;

        return $this;
    }

    /**
     * Get responseRole
     *
     * @return string
     */
    public function getResponseRole()
    {
        return $this->responseRole;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return UserVideohistory
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
     * Set fkUserSession
     *
     * @param \ApiV3\Entity\UserSession $fkUserSession
     *
     * @return UserVideohistory
     */
    public function setFkUserSession(\ApiV3\Entity\UserSession $fkUserSession = null)
    {
        $this->fkUserSession = $fkUserSession;

        return $this;
    }

    /**
     * Get fkUserSession
     *
     * @return \ApiV3\Entity\UserSession
     */
    public function getFkUserSession()
    {
        return $this->fkUserSession;
    }

    /**
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return UserVideohistory
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
     * Set fkResponse
     *
     * @param \ApiV3\Entity\Response $fkResponse
     *
     * @return UserVideohistory
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
     * Set fkSubtitle
     *
     * @param \ApiV3\Entity\Subtitle $fkSubtitle
     *
     * @return UserVideohistory
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
}
