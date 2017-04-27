<?php

namespace ApiV3\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;

class AbstractController
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
        return $this->_methodNotAllowed();
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

    public function options()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(200);
        $json->setVariables(array());
        return $json;
    }

    protected function _methodNotAllowed()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(405);
        return $json;
    }

    protected function _notFound()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(404);
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

    public function getService($service)
    {

        $serviceManager = $this->getEvent()
            ->getApplication()
            ->getServiceManager();

        if ($serviceManager->has($service)) {
            return $serviceManager->get($service);
        }

        return false;

    }

}