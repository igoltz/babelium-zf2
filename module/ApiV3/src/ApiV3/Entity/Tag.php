<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity
 */
class Tag
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
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ApiV3\Entity\Exercise", mappedBy="fkTag")
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
     * Set name
     *
     * @param string $name
     *
     * @return Tag
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
     * Add fkExercise
     *
     * @param \ApiV3\Entity\Exercise $fkExercise
     *
     * @return Tag
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
