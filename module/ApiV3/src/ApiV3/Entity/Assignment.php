<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignment
 *
 * @ORM\Table(name="assignment", indexes={@ORM\Index(name="fk_assignment_1", columns={"fk_course_id"}), @ORM\Index(name="fk_assignment_2_idx", columns={"fk_exercise_id"})})
 * @ORM\Entity
 */
class Assignment
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="duedate", type="bigint", nullable=false)
     */
    private $duedate = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="allowsubmissionsfromdate", type="bigint", nullable=false)
     */
    private $allowsubmissionsfromdate = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="grade", type="bigint", nullable=false)
     */
    private $grade = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="bigint", nullable=false)
     */
    private $timemodified = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="maxattempts", type="integer", nullable=false)
     */
    private $maxattempts = '0';

    /**
     * @var \ApiV3\Entity\Course
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Course")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_course_id", referencedColumnName="id")
     * })
     */
    private $fkCourse;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Assignment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Assignment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duedate
     *
     * @param integer $duedate
     *
     * @return Assignment
     */
    public function setDuedate($duedate)
    {
        $this->duedate = $duedate;

        return $this;
    }

    /**
     * Get duedate
     *
     * @return integer
     */
    public function getDuedate()
    {
        return $this->duedate;
    }

    /**
     * Set allowsubmissionsfromdate
     *
     * @param integer $allowsubmissionsfromdate
     *
     * @return Assignment
     */
    public function setAllowsubmissionsfromdate($allowsubmissionsfromdate)
    {
        $this->allowsubmissionsfromdate = $allowsubmissionsfromdate;

        return $this;
    }

    /**
     * Get allowsubmissionsfromdate
     *
     * @return integer
     */
    public function getAllowsubmissionsfromdate()
    {
        return $this->allowsubmissionsfromdate;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Assignment
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set timemodified
     *
     * @param integer $timemodified
     *
     * @return Assignment
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
     * Set maxattempts
     *
     * @param integer $maxattempts
     *
     * @return Assignment
     */
    public function setMaxattempts($maxattempts)
    {
        $this->maxattempts = $maxattempts;

        return $this;
    }

    /**
     * Get maxattempts
     *
     * @return integer
     */
    public function getMaxattempts()
    {
        return $this->maxattempts;
    }

    /**
     * Set fkCourse
     *
     * @param \ApiV3\Entity\Course $fkCourse
     *
     * @return Assignment
     */
    public function setFkCourse(\ApiV3\Entity\Course $fkCourse = null)
    {
        $this->fkCourse = $fkCourse;

        return $this;
    }

    /**
     * Get fkCourse
     *
     * @return \ApiV3\Entity\Course
     */
    public function getFkCourse()
    {
        return $this->fkCourse;
    }

    /**
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return Assignment
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
}
