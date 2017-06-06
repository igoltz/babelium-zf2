<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLanguages
 *
 * @ORM\Table(name="user_languages", indexes={@ORM\Index(name="fk_user_id", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class UserLanguages
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
     * @ORM\Column(name="language", type="string", length=45, nullable=false)
     */
    private $language;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=false, options={"comment": "Level goes from 1 to 6. 7 used for mother tongue", "unsigned": true})
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="positives_to_next_level", type="integer", nullable=false, options={"unsigned": true})
     */
    private $positivesToNextLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="purpose", type="string", nullable=false, columnDefinition="ENUM('practice','evaluate')", options={"default": "practice"})
     */
    private $purpose = 'practice';

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
     * Set language
     *
     * @param string $language
     *
     * @return UserLanguages
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return UserLanguages
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set positivesToNextLevel
     *
     * @param integer $positivesToNextLevel
     *
     * @return UserLanguages
     */
    public function setPositivesToNextLevel($positivesToNextLevel)
    {
        $this->positivesToNextLevel = $positivesToNextLevel;

        return $this;
    }

    /**
     * Get positivesToNextLevel
     *
     * @return integer
     */
    public function getPositivesToNextLevel()
    {
        return $this->positivesToNextLevel;
    }

    /**
     * Set purpose
     *
     * @param string $purpose
     *
     * @return UserLanguages
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Get purpose
     *
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return UserLanguages
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
