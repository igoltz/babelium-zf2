<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Credithistory
 *
 * @ORM\Table(name="credithistory", indexes={@ORM\Index(name="FK_credithistory_1", columns={"fk_user_id"}), @ORM\Index(name="FK_credithistory_3", columns={"fk_response_id"}), @ORM\Index(name="FK_credithistory_2", columns={"fk_exercise_id"})})
 * @ORM\Entity
 */
class Credithistory
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
     * @var integer
     *
     * @ORM\Column(name="fk_eval_id", type="integer", nullable=true)
     */
    private $fkEvalId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changeDate", type="datetime", nullable=false)
     */
    private $changedate;

    /**
     * @var string
     *
     * @ORM\Column(name="changeType", type="string", length=45, nullable=false)
     */
    private $changetype;

    /**
     * @var integer
     *
     * @ORM\Column(name="changeAmount", type="integer", nullable=false)
     */
    private $changeamount = '0';

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
     * @var \ApiV3\Entity\Exercise
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Exercise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_exercise_id", referencedColumnName="id")
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkEvalId
     *
     * @param integer $fkEvalId
     *
     * @return Credithistory
     */
    public function setFkEvalId($fkEvalId)
    {
        $this->fkEvalId = $fkEvalId;

        return $this;
    }

    /**
     * Get fkEvalId
     *
     * @return integer
     */
    public function getFkEvalId()
    {
        return $this->fkEvalId;
    }

    /**
     * Set changedate
     *
     * @param \DateTime $changedate
     *
     * @return Credithistory
     */
    public function setChangedate($changedate)
    {
        $this->changedate = $changedate;

        return $this;
    }

    /**
     * Get changedate
     *
     * @return \DateTime
     */
    public function getChangedate()
    {
        return $this->changedate;
    }

    /**
     * Set changetype
     *
     * @param string $changetype
     *
     * @return Credithistory
     */
    public function setChangetype($changetype)
    {
        $this->changetype = $changetype;

        return $this;
    }

    /**
     * Get changetype
     *
     * @return string
     */
    public function getChangetype()
    {
        return $this->changetype;
    }

    /**
     * Set changeamount
     *
     * @param integer $changeamount
     *
     * @return Credithistory
     */
    public function setChangeamount($changeamount)
    {
        $this->changeamount = $changeamount;

        return $this;
    }

    /**
     * Get changeamount
     *
     * @return integer
     */
    public function getChangeamount()
    {
        return $this->changeamount;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Credithistory
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
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return Credithistory
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
     * @return Credithistory
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
}
