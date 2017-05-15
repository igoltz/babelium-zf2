<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RelCourseRoleUser
 *
 * @ORM\Table(name="rel_course_role_user", indexes={@ORM\Index(name="fk_rel_course_role_user_1", columns={"fk_course_id"}), @ORM\Index(name="fk_rel_course_role_user_2", columns={"fk_role_id"}), @ORM\Index(name="fk_rel_course_role_user_3", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class RelCourseRoleUser
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
     * @ORM\Column(name="timemodified", type="bigint", nullable=false)
     */
    private $timemodified = '0';

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
     * @var \ApiV3\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_role_id", referencedColumnName="id")
     * })
     */
    private $fkRole;

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
     * Set timemodified
     *
     * @param integer $timemodified
     *
     * @return RelCourseRoleUser
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
     * Set fkCourse
     *
     * @param \ApiV3\Entity\Course $fkCourse
     *
     * @return RelCourseRoleUser
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
     * Set fkRole
     *
     * @param \ApiV3\Entity\Role $fkRole
     *
     * @return RelCourseRoleUser
     */
    public function setFkRole(\ApiV3\Entity\Role $fkRole = null)
    {
        $this->fkRole = $fkRole;

        return $this;
    }

    /**
     * Get fkRole
     *
     * @return \ApiV3\Entity\Role
     */
    public function getFkRole()
    {
        return $this->fkRole;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return RelCourseRoleUser
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
