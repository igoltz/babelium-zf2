<?php

namespace ApiV3\Controller;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class SubTitlesController
    extends AbstractController
{

    /**
     * Obtiene la información relacionado con un subtitulo
     *
     * {@inheritDoc}
     * @see \ApiV3\Controller\AbstractController::get()
     */
    public function get($id)
    {

        $vtt = false;
        if (strpos($id, '.vtt') !== false) {
            $vtt = true;
            $id = str_replace('.vtt', '', $id);
        }

        $sql = 'SELECT * FROM subtitle where id = :id';

        $params = array(
            'id' => $id
        );
        $stmt= $this->getDoctrineConnection()->prepare($sql);
        $stmt->execute($params);

        $subtitle = $stmt->fetch();
        if (empty($subtitle)) {
            return $this->_notFound();
        }

        $subtService = $this->getService('SubTitlesService');
        $parseSubtitles = $subtService->parseSubtitles($subtitle);

        /**
         * Respuesta en formato JSON
         */
        if ($vtt === false) {
            $json = new JsonModel();
            $json->setVariables($parseSubtitles);
            $this->response->setStatusCode(200);
            return $json;

        }

        $fileContent = $subtService->generatoFileContent($parseSubtitles);

        $headers = new \Zend\Http\Headers();
        $headers->addHeaderLine('Content-Type:text/vtt;charset=utf-8');

        $response = new \Zend\Http\Response();
        $response->setContent($fileContent);
        $response->setHeaders($headers);

        return $response;

    }

}
