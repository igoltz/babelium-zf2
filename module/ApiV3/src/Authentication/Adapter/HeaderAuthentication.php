<?php

namespace ApiV3\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Http\Request;

class HeaderAuthentication
    implements AdapterInterface
{

    /**
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * @var \Zend\Http\Response
     */
    protected $response;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $doctrine;

    public function __construct(
        $request,
        $response,
        $doctrine
    )
    {

        $this->request  = $request;
        $this->response = $response;
        $this->doctrine = $doctrine;

        return $this;
    }

    public function authenticate()
    {

        $headers = $this->request->getHeaders();

        /**
         * Si va a descargar un .vtt de subtitulos, no requiere de autenticación
         */
        $path = $this->request->getUri()->getPath();
        $isSubtitleVTT = $this->_isSubtitleVTT($path);
        if ($isSubtitleVTT) {
            return new Result(Result::SUCCESS, array());
        }

        /**
         * Comprueba que existan las 2 cabeceras de autenticación
         */
        if (!$headers->has('Access-Key') || !$headers->has('Secret-Access')) {
            return new Result(
                Result::FAILURE,
                null,
                array('Authorization header missing')
            );
        }

        $consumer = $this->_getConsumer();
        if ($consumer === false) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                array('User not found')
            );
        }

        return new Result(Result::SUCCESS, $consumer);

    }

    /**
     * Comprueba que la uri sea para obtener un subtitulo
     *
     * @param string $path
     * @return boolean
     */
    protected function _isSubtitleVTT($path)
    {

        $ext = substr($path, -4);

        if ($ext === '.vtt' && strpos($path, '/sub-titles/')) {
            return true;
        }

        return false;
    }

    /**
     * En base a las 2 cabeceras de autenticación, se busca y valida el moodle
     *
     * @return mixed
     */
    protected function _getConsumer()
    {

        $headers = $this->request->getHeaders();

        $accessKey = $headers->get('Access-Key')->getFieldValue();
        $secretAccess = $headers->get('Secret-Access')->getFieldValue();

        $sql = 'SELECT * FROM serviceconsumer WHERE access_key = :access_key AND secret_access_key = :secret_access_key';

        $params = array(
            'access_key' => $accessKey,
            'secret_access_key' => $secretAccess
        );

        $stmt = $this->doctrine->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();

    }

}