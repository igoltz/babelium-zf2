<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseLike
 *
 * @ORM\Table(name="exercise_like", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE_exercise_like", columns={"fk_exercise_id", "fk_user_id"})}, indexes={@ORM\Index(name="FK_exercise_like_1", columns={"fk_exercise_id"}), @ORM\Index(name="FK_exercise_like_2", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class ExerciseLike
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
     * @ORM\Column(name="like", type="boolean", nullable=false)
     */
    private $like = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="integer", nullable=false)
     */
    private $timecreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="integer", nullable=false)
     */
    private $timemodified;

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
     * Set like
     *
     * @param boolean $like
     *
     * @return ExerciseLike
     */
    public function setLike($like)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * Get like
     *
     * @return boolean
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return ExerciseLike
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
     * @return ExerciseLike
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
     * Set fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return ExerciseLike
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
     * @return ExerciseLike
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
