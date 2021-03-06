<?php

namespace ApiV3\Services;

class Authentication
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function __construct($container)
    {
        $this->_doctrineConnection = $container
            ->get('Doctrine\ORM\EntityManager')
            ->getConnection();
    }

    /**
     * Comprueba que la uri sea para obtener un archivo de subtitulo .vtt
     *
     * @param string $path
     * @return boolean
     */
    public function isSubtitleVTT($path)
    {

        $ext = substr($path, -4);

        if ($ext === '.vtt' && strpos($path, '/sub-titles/')) {
            return true;
        }

        return false;

    }

    /**
     * Comprueba que la uri sea para obtener un thumbnail o un video
     *
     * @param string $path
     * @return boolean
     */
    public function isMedia($path)
    {

        if (
            strpos($path, '/thumbnail/')
        ||
            strpos($path, '/media/')
        ||
            strpos($path, '/video-response/')
        ) {
            return true;
        }

        return false;

    }

    /**
     * Comprueba que existan las 2 cabeceras de autenticación
     *
     * @param \Zend\Http\Headers $headers
     * @return boolean
     */
    public function validHeaders(
        \Zend\Http\Headers $headers
    )
    {
        return $headers->has('Access-Key') && $headers->has('Secret-Access');
    }

    /**
     *
     * @param unknown $subscriptionStart
     * @param unknown $subscriptionEnd
     * @return string|boolean
     */
    public function subscriptionValid(
        $subscriptionStart,
        $subscriptionEnd
    )
    {

        if ($subscriptionStart && time() < $subscriptionStart) {
            return 'Subscription not yet started';
        }

        if ($subscriptionEnd && time() >= $subscriptionEnd) {
            return 'Subscription expired';
        }

        return true;

    }

    /**
     * Comprueba que la ip de la petición, sea una de las validas.
     *
     * @param array $consumer
     * @return boolean
     */
    public function ipAddressValid($consumer)
    {

        $consIpAdress = $consumer['ipaddress'];
        $remoteIpAddress = $_SERVER['REMOTE_ADDR'];

        if (!empty($consIpAdress)) {
            if (strpos($consIpAdress, ',') !== FALSE) {
                $consIpAdress = explode(',', $consIpAdress);
                if (!in_array($remoteIpAddress, $consIpAdress)) {
                    return false;
                }
            } else {
                if ($remoteIpAddress != $consIpAdress) {
                    return false;
                }
            }
        }

        return true;

    }

}