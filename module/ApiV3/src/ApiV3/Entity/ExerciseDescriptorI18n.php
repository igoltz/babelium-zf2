<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseDescriptorI18n
 *
 * @ORM\Table(name="exercise_descriptor_i18n", indexes={@ORM\Index(name="fk_exercise_descriptor_i18n_1", columns={"fk_exercise_descriptor_id"})})
 * @ORM\Entity
 */
class ExerciseDescriptorI18n
{

    /**
     * @var \ApiV3\Entity\ExerciseDescriptor
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiV3\Entity\ExerciseDescriptor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_exercise_descriptor_id", referencedColumnName="id")
     * })
     */
    private $fkExerciseDescriptor;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="locale", type="string", length=8, nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=false)
     */
    private $name;

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return ExerciseDescriptorI18n
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ExerciseDescriptorI18n
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
     * Set fkExerciseDescriptor
     *
     * @param \ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor
     *
     * @return ExerciseDescriptorI18n
     */
    public function setFkExerciseDescriptor(\ApiV3\Entity\ExerciseDescriptor $fkExerciseDescriptor)
    {
        $this->fkExerciseDescriptor = $fkExerciseDescriptor;

        return $this;
    }

    /**
     * Get fkExerciseDescriptor
     *
     * @return \ApiV3\Entity\ExerciseDescriptor
     */
    public function getFkExerciseDescriptor()
    {
        return $this->fkExerciseDescriptor;
    }
}
