<?php

namespace ApiV3\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpinvoxRequest
 *
 * @ORM\Table(name="spinvox_request", indexes={@ORM\Index(name="fk_spinvox_requests_transcription1", columns={"fk_transcription_id"})})
 * @ORM\Entity
 */
class SpinvoxRequest
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
     * @ORM\Column(name="x_error", type="string", length=45, nullable=false)
     */
    private $xError;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200, nullable=true)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \ApiV3\Entity\Transcription
     *
     * @ORM\ManyToOne(targetEntity="ApiV3\Entity\Transcription")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_transcription_id", referencedColumnName="id")
     * })
     */
    private $fkTranscription;



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
     * Set xError
     *
     * @param string $xError
     *
     * @return SpinvoxRequest
     */
    public function setXError($xError)
    {
        $this->xError = $xError;

        return $this;
    }

    /**
     * Get xError
     *
     * @return string
     */
    public function getXError()
    {
        return $this->xError;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return SpinvoxRequest
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SpinvoxRequest
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set fkTranscription
     *
     * @param \ApiV3\Entity\Transcription $fkTranscription
     *
     * @return SpinvoxRequest
     */
    public function setFkTranscription(\ApiV3\Entity\Transcription $fkTranscription = null)
    {
        $this->fkTranscription = $fkTranscription;

        return $this;
    }

    /**
     * Get fkTranscription
     *
     * @return \ApiV3\Entity\Transcription
     */
    public function getFkTranscription()
    {
        return $this->fkTranscription;
    }
}
