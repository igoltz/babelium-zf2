<?php

namespace ApiV3\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use JMS\Serializer\SerializationContext;
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

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getService('Doctrine\ORM\EntityManager');
    }

    protected function getDoctrineRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * @param array|string $data
     */
    protected function jsonResponse($data, $groups = array())
    {

        $json = new JsonModel();
        $json->setVariables($this->entityToArray($data, $groups));
        $this->response->setStatusCode(200);

        return $json;

    }

    protected function entityToArray($entity, $groups = array())
    {

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();

        if (empty($groups)) {
            $context = SerializationContext::create();
        } else {
            $context = SerializationContext::create()->setGroups($groups);
        }

        $jsonContent = $serializer->serialize(
            $entity,
            'json',
            $context
        );

        return json_decode($jsonContent, true);

    }

    /**
     * @param string $service
     */
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

    public function getBaseUrl()
    {

        $url = sprintf(
            '%s://%s%s',
            $this->request->getServer()->get('REQUEST_SCHEME'),
            $this->request->getServer()->get('HTTP_HOST'),
            $this->request->getBasePath()
        );

        return $url;

    }

}