<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceconsumerLog
 *
 * @ORM\Table(name="serviceconsumer_log")
 * @ORM\Entity
 */
class ServiceconsumerLog
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
     * @ORM\Column(name="time", type="bigint", nullable=false, options={"unsigned": true, "default": 0})
     */
    private $time = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=45, nullable=false, options={"default": ""})
     */
    private $method = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="statuscode", type="integer", nullable=false, options={"default": 500})
     */
    private $statuscode = '500';

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="ipaddress", type="string", length=45, nullable=false, options={"default": ""})
     */
    private $ipaddress = '';

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=false, options={"default": ""})
     */
    private $origin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="string", length=255, nullable=false, options={"default": ""})
     */
    private $referer = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_serviceconsumer_id", type="integer", nullable=true, options={"unsigned": true})
     */
    private $fkServiceconsumerId;



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
     * Set time
     *
     * @param integer $time
     *
     * @return ServiceconsumerLog
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return ServiceconsumerLog
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set statuscode
     *
     * @param integer $statuscode
     *
     * @return ServiceconsumerLog
     */
    public function setStatuscode($statuscode)
    {
        $this->statuscode = $statuscode;

        return $this;
    }

    /**
     * Get statuscode
     *
     * @return integer
     */
    public function getStatuscode()
    {
        return $this->statuscode;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return ServiceconsumerLog
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
     * Set ipaddress
     *
     * @param string $ipaddress
     *
     * @return ServiceconsumerLog
     */
    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    /**
     * Get ipaddress
     *
     * @return string
     */
    public function getIpaddress()
    {
        return $this->ipaddress;
    }

    /**
     * Set origin
     *
     * @param string $origin
     *
     * @return ServiceconsumerLog
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set referer
     *
     * @param string $referer
     *
     * @return ServiceconsumerLog
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set fkServiceconsumerId
     *
     * @param integer $fkServiceconsumerId
     *
     * @return ServiceconsumerLog
     */
    public function setFkServiceconsumerId($fkServiceconsumerId)
    {
        $this->fkServiceconsumerId = $fkServiceconsumerId;

        return $this;
    }

    /**
     * Get fkServiceconsumerId
     *
     * @return integer
     */
    public function getFkServiceconsumerId()
    {
        return $this->fkServiceconsumerId;
    }
}
