<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Motd
 *
 * @ORM\Table(name="motd")
 * @ORM\Entity
 */
class Motd
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
     * @ORM\Column(name="title", type="string", length=250, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="resource", type="string", length=250, nullable=false)
     */
    private $resource;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="displaydate", type="datetime", nullable=false)
     */
    private $displaydate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="displaywhenloggedin", type="boolean", nullable=false)
     */
    private $displaywhenloggedin = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=5, nullable=false)
     */
    private $language;



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
     * Set title
     *
     * @param string $title
     *
     * @return Motd
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Motd
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set resource
     *
     * @param string $resource
     *
     * @return Motd
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set displaydate
     *
     * @param \DateTime $displaydate
     *
     * @return Motd
     */
    public function setDisplaydate($displaydate)
    {
        $this->displaydate = $displaydate;

        return $this;
    }

    /**
     * Get displaydate
     *
     * @return \DateTime
     */
    public function getDisplaydate()
    {
        return $this->displaydate;
    }

    /**
     * Set displaywhenloggedin
     *
     * @param boolean $displaywhenloggedin
     *
     * @return Motd
     */
    public function setDisplaywhenloggedin($displaywhenloggedin)
    {
        $this->displaywhenloggedin = $displaywhenloggedin;

        return $this;
    }

    /**
     * Get displaywhenloggedin
     *
     * @return boolean
     */
    public function getDisplaywhenloggedin()
    {
        return $this->displaywhenloggedin;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Motd
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Motd
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
}
