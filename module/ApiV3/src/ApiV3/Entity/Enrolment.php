<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enrolment
 *
 * @ORM\Table(name="enrolment", indexes={@ORM\Index(name="fk_enrolment_1_idx", columns={"fk_group_id"})})
 * @ORM\Entity
 */
class Enrolment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="fk_user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $fkUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    private $role = 'student';

    /**
     * @var \ApiV3\Entity\Groups
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ApiV3\Entity\Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_group_id", referencedColumnName="ID")
     * })
     */
    private $fkGroup;



    /**
     * Set fkUserId
     *
     * @param integer $fkUserId
     *
     * @return Enrolment
     */
    public function setFkUserId($fkUserId)
    {
        $this->fkUserId = $fkUserId;

        return $this;
    }

    /**
     * Get fkUserId
     *
     * @return integer
     */
    public function getFkUserId()
    {
        return $this->fkUserId;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Enrolment
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set fkGroup
     *
     * @param \ApiV3\Entity\Groups $fkGroup
     *
     * @return Enrolment
     */
    public function setFkGroup(\ApiV3\Entity\Groups $fkGroup)
    {
        $this->fkGroup = $fkGroup;

        return $this;
    }

    /**
     * Get fkGroup
     *
     * @return \ApiV3\Entity\Groups
     */
    public function getFkGroup()
    {
        return $this->fkGroup;
    }
}
