<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssignmentSubmission
 *
 * @ORM\Table(name="assignment_submission", indexes={@ORM\Index(name="fk_assignment_submission_1", columns={"fk_assignment_id"}), @ORM\Index(name="fk_assignment_submission_2", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class AssignmentSubmission
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
     * @ORM\Column(name="timecreated", type="bigint", nullable=false)
     */
    private $timecreated = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="bigint", nullable=false)
     */
    private $timemodified = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="attempnumber", type="integer", nullable=true)
     */
    private $attempnumber = '0';

    /**
     * @var \ApiV3\Entity\Assignment
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Assignment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_assignment_id", referencedColumnName="id")
     * })
     */
    private $fkAssignment;

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
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return AssignmentSubmission
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
     * @return AssignmentSubmission
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
     * Set status
     *
     * @param string $status
     *
     * @return AssignmentSubmission
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
     * Set attempnumber
     *
     * @param integer $attempnumber
     *
     * @return AssignmentSubmission
     */
    public function setAttempnumber($attempnumber)
    {
        $this->attempnumber = $attempnumber;

        return $this;
    }

    /**
     * Get attempnumber
     *
     * @return integer
     */
    public function getAttempnumber()
    {
        return $this->attempnumber;
    }

    /**
     * Set fkAssignment
     *
     * @param \ApiV3\Entity\Assignment $fkAssignment
     *
     * @return AssignmentSubmission
     */
    public function setFkAssignment(\ApiV3\Entity\Assignment $fkAssignment = null)
    {
        $this->fkAssignment = $fkAssignment;

        return $this;
    }

    /**
     * Get fkAssignment
     *
     * @return \ApiV3\Entity\Assignment
     */
    public function getFkAssignment()
    {
        return $this->fkAssignment;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return AssignmentSubmission
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
