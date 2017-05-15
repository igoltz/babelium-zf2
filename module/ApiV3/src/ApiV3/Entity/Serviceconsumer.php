<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Serviceconsumer
 *
 * @ORM\Table(name="serviceconsumer", uniqueConstraints={@ORM\UniqueConstraint(name="access_key_UNIQUE", columns={"access_key"}), @ORM\UniqueConstraint(name="domainforuser_UNIQUE", columns={"domain", "fk_user_id"})}, indexes={@ORM\Index(name="fk_moodle_api_1", columns={"fk_user_id"})})
 * @ORM\Entity
 */
class Serviceconsumer
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
     * @ORM\Column(name="access_key", type="string", length=20, nullable=false)
     */
    private $accessKey;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_access_key", type="string", length=40, nullable=false)
     */
    private $secretAccessKey;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=100, nullable=false)
     */
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdomain", type="string", length=100, nullable=false)
     */
    private $rawdomain;

    /**
     * @var string
     *
     * @ORM\Column(name="ipaddress", type="string", length=255, nullable=false)
     */
    private $ipaddress = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="subscriptionstart", type="bigint", nullable=false)
     */
    private $subscriptionstart = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="subscriptionend", type="bigint", nullable=false)
     */
    private $subscriptionend = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="notifyexpiration", type="boolean", nullable=false)
     */
    private $notifyexpiration = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timecreated", type="bigint", nullable=false)
     */
    private $timecreated = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="timemodified", type="bigint", nullable=false)
     */
    private $timemodified = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled = '1';

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
     * Set accessKey
     *
     * @param string $accessKey
     *
     * @return Serviceconsumer
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    /**
     * Get accessKey
     *
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * Set secretAccessKey
     *
     * @param string $secretAccessKey
     *
     * @return Serviceconsumer
     */
    public function setSecretAccessKey($secretAccessKey)
    {
        $this->secretAccessKey = $secretAccessKey;

        return $this;
    }

    /**
     * Get secretAccessKey
     *
     * @return string
     */
    public function getSecretAccessKey()
    {
        return $this->secretAccessKey;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return Serviceconsumer
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set rawdomain
     *
     * @param string $rawdomain
     *
     * @return Serviceconsumer
     */
    public function setRawdomain($rawdomain)
    {
        $this->rawdomain = $rawdomain;

        return $this;
    }

    /**
     * Get rawdomain
     *
     * @return string
     */
    public function getRawdomain()
    {
        return $this->rawdomain;
    }

    /**
     * Set ipaddress
     *
     * @param string $ipaddress
     *
     * @return Serviceconsumer
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
     * Set subscriptionstart
     *
     * @param integer $subscriptionstart
     *
     * @return Serviceconsumer
     */
    public function setSubscriptionstart($subscriptionstart)
    {
        $this->subscriptionstart = $subscriptionstart;

        return $this;
    }

    /**
     * Get subscriptionstart
     *
     * @return integer
     */
    public function getSubscriptionstart()
    {
        return $this->subscriptionstart;
    }

    /**
     * Set subscriptionend
     *
     * @param integer $subscriptionend
     *
     * @return Serviceconsumer
     */
    public function setSubscriptionend($subscriptionend)
    {
        $this->subscriptionend = $subscriptionend;

        return $this;
    }

    /**
     * Get subscriptionend
     *
     * @return integer
     */
    public function getSubscriptionend()
    {
        return $this->subscriptionend;
    }

    /**
     * Set notifyexpiration
     *
     * @param boolean $notifyexpiration
     *
     * @return Serviceconsumer
     */
    public function setNotifyexpiration($notifyexpiration)
    {
        $this->notifyexpiration = $notifyexpiration;

        return $this;
    }

    /**
     * Get notifyexpiration
     *
     * @return boolean
     */
    public function getNotifyexpiration()
    {
        return $this->notifyexpiration;
    }

    /**
     * Set timecreated
     *
     * @param integer $timecreated
     *
     * @return Serviceconsumer
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
     * @return Serviceconsumer
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Serviceconsumer
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set fkUser
     *
     * @param \ApiV3\Entity\User $fkUser
     *
     * @return Serviceconsumer
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
