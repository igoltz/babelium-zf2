<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Preferences
 *
 * @ORM\Table(name="preferences", uniqueConstraints={@ORM\UniqueConstraint(name="prefName_UNIQUE", columns={"prefName"})})
 * @ORM\Entity
 */
class Preferences
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
     * @ORM\Column(name="prefName", type="string", length=45, nullable=false)
     */
    private $prefname;

    /**
     * @var string
     *
     * @ORM\Column(name="prefValue", type="string", length=200, nullable=false)
     */
    private $prefvalue;



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
     * Set prefname
     *
     * @param string $prefname
     *
     * @return Preferences
     */
    public function setPrefname($prefname)
    {
        $this->prefname = $prefname;

        return $this;
    }

    /**
     * Get prefname
     *
     * @return string
     */
    public function getPrefname()
    {
        return $this->prefname;
    }

    /**
     * Set prefvalue
     *
     * @param string $prefvalue
     *
     * @return Preferences
     */
    public function setPrefvalue($prefvalue)
    {
        $this->prefvalue = $prefvalue;

        return $this;
    }

    /**
     * Get prefvalue
     *
     * @return string
     */
    public function getPrefvalue()
    {
        return $this->prefvalue;
    }
}
