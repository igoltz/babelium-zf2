<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseDescriptor
 *
 * @ORM\Table(name="exercise_descriptor", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"situation", "level", "competence", "number"})})
 * @ORM\Entity
 */
class ExerciseDescriptor
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
     * @ORM\Column(name="situation", type="boolean", nullable=false, options={"default": 1, "unsigned": true})
     */
    private $situation = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="level", type="boolean", nullable=false, options={"default": 1, "unsigned": true})
     */
    private $level = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="competence", type="boolean", nullable=false, options={"default": 1, "unsigned": true})
     */
    private $competence = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer", nullable=false, options={"default": 1, "unsigned": true})
     */
    private $number = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="alte", type="boolean", nullable=false, options={"default": 0, "unsigned": true})
     */
    private $alte = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiV3\Entity\Exercise", mappedBy="fkExerciseDescriptor")
     */
    private $fkExercise;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkExercise = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set situation
     *
     * @param boolean $situation
     *
     * @return ExerciseDescriptor
     */
    public function setSituation($situation)
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * Get situation
     *
     * @return boolean
     */
    public function getSituation()
    {
        return $this->situation;
    }

    /**
     * Set level
     *
     * @param boolean $level
     *
     * @return ExerciseDescriptor
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return boolean
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set competence
     *
     * @param boolean $competence
     *
     * @return ExerciseDescriptor
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return boolean
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return ExerciseDescriptor
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set alte
     *
     * @param boolean $alte
     *
     * @return ExerciseDescriptor
     */
    public function setAlte($alte)
    {
        $this->alte = $alte;

        return $this;
    }

    /**
     * Get alte
     *
     * @return boolean
     */
    public function getAlte()
    {
        return $this->alte;
    }

    /**
     * Add fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return ExerciseDescriptor
     */
    public function addFkExercise(\ApiV3\Entity\Exercise $fkExercise)
    {
        $this->fkExercise[] = $fkExercise;

        return $this;
    }

    /**
     * Remove fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     */
    public function removeFkExercise(\ApiV3\Entity\Exercise $fkExercise)
    {
        $this->fkExercise->removeElement($fkExercise);
    }

    /**
     * Get fkExercise
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkExercise()
    {
        return $this->fkExercise;
    }
}
