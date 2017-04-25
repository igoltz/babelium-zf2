<?php

namespace ApiV3\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class SubTitlesController
    extends AbstractRestfulController
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function getList()
    {
        return $this->_methodNotAllowed();
    }

    public function get($id)
    {

        $result = array();

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
            $json = new JsonModel();
            $json->setVariables($result);
            $this->response->setStatusCode(404);
            return $json;
        }

        $subtService= new \ApiV3\Services\SubTitles();
        $parseSubtitles = $subtService->parseSubtitles($subtitle);

        /**
         * Respuesta en formato JSON
         */
        if ($vtt === false) {
            $subtitles = \Zend\Json\Json::encode($parseSubtitles, true);

            $result['subtitles'] = $subtitles;

            $json = new JsonModel();
            $json->setVariables($result);
            $this->response->setStatusCode(200);

            return $json;

        }

        /**
         * Respuesta en Formato .vtt
         */

        $vttFile = new \Captioning\Format\WebvttFile();
        foreach ($parseSubtitles as $lineSubtitle) {

            if ($lineSubtitle->exerciseRoleName === 'NPC') {
                $user = '<v NPC>';
            } else {
                $user = '<v Yourself>';
            }

            $vttFile->addCue(
                $user . $lineSubtitle->text . '</v>',
                $subtService->getFormatTimeBySeconds($lineSubtitle->showTime),
                $subtService->getFormatTimeBySeconds($lineSubtitle->hideTime)
            );

        }

        $vttFile->build();

        $headers = new \Zend\Http\Headers();
        $headers->addHeaderLine('Content-Type:text/vtt;charset=utf-8');

        $response = new \Zend\Http\Response();
        $response->setContent($vttFile->getFileContent());
        $response->setHeaders($headers);

        return $response;

    }

    public function create($data)
    {
        return $this->_methodNotAllowed();
    }

    public function update($id, $data)
    {
        return $this->_methodNotAllowed();
    }

    public function delete($id)
    {
        return $this->_methodNotAllowed();
    }

    protected function _methodNotAllowed()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(405);
        return $json;
    }

    protected function getDoctrineConnection()
    {

        if (!$this->_doctrineConnection) {
            $this->_doctrineConnection = $this->getEvent()
            ->getApplication()
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getConnection();
        }

        return $this->_doctrineConnection;

    }

}
