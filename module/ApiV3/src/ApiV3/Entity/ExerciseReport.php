<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseReport
 *
 * @ORM\Table(name="exercise_report", indexes={@ORM\Index(name="FK_exercise_report_1", columns={"fk_exercise_id"}), @ORM\Index(name="FK_exercise_report_2", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class ExerciseReport
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
     * @ORM\Column(name="reason", type="string", length=100, nullable=false)
     */
    private $reason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="report_date", type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $reportDate = 'CURRENT_TIMESTAMP';

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
     * Set reason
     *
     * @param string $reason
     *
     * @return ExerciseReport
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set reportDate
     *
     * @param \DateTime $reportDate
     *
     * @return ExerciseReport
     */
    public function setReportDate($reportDate)
    {
        $this->reportDate = $reportDate;

        return $this;
    }

    /**
     * Get reportDate
     *
     * @return \DateTime
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return ExerciseReport
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
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return ExerciseReport
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
