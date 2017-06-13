<?php
/**
 * Babelium Project open source collaborative second language oral practice
 * http://www.babeliumproject.com
 *
 * Copyright (c) 2011 GHyM and by respective authors (see below).
 *
 * This file is part of Babelium Project.
 *
 * Babelium Project is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Babelium Project is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.6/7
 *
 * @category Command
 * @package  ApiV3
 * @author   Elurnet Informatika Zerbitzuak S.L - Irontec
 * @license  GNU <http://www.gnu.org/licenses/>
 * @link     https://github.com/babeliumproject
 */

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

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
     */
    public function getList()
    {
        return $this->_methodNotAllowed();
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::get()
     */
    public function get($id)
    {
        return $this->_methodNotAllowed();
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::create()
     */
    public function create($data)
    {
        return $this->_methodNotAllowed();
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::update()
     */
    public function update($id, $data)
    {
        return $this->_methodNotAllowed();
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::delete()
     */
    public function delete($id)
    {
        return $this->_methodNotAllowed();
    }

    /**
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractRestfulController::options()
     */
    public function options()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(200);
        $json->setVariables(array());
        return $json;
    }

    public function _methodNotAllowed()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(405);
        return $json;
    }

    public function _notFound()
    {
        $json = new JsonModel();
        $this->response->setStatusCode(404);
        return $json;
    }

    public function getDoctrineConnection()
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
    public function getEntityManager()
    {
        return $this->getService('Doctrine\ORM\EntityManager');
    }

    public function getDoctrineRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * @param array|string $data
     */
    public function jsonResponse($data, $groups = array())
    {

        $json = new JsonModel();
        $json->setVariables($this->entityToArray($data, $groups));
        $this->response->setStatusCode(200);

        return $json;

    }

    public function entityToArray($entity, $groups = array())
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
     * @param  string $service Nombre del servicio
     * @return boolean|object
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

    /**
     * @return string
     */
    public function getBaseUrl()
    {

        $url = sprintf(
            'https://%s%s',
            $this->request->getServer()->get('HTTP_HOST'),
            $this->request->getBasePath()
        );

        return $url;

    }

}