<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApiV3\Controller;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;

class IndexController extends AbstractRestfulController
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function indexAction()
    {

//         var_dump($this->getObjectManager());
//         $users = $this->getObjectManager()->getRepository('\Application\Entity\User')->findAll();
//         var_dump($users);
//         die();

        //var_dump($this->getDoctrineConnection()->query('SELECT * FROM subtitle where id = 6')->fetchAll());

        $data = array(
            'status' => 200,
            'msg' => 'Ok!'
        );

        $json = new JsonModel($data);
        $json->setVariables($data);
        $this->response->setStatusCode(500);

        return $json;

    }

    protected function getDoctrineConnection()
    {

        if (!$this->_doctrineConnection) {
            $this->_doctrineConnection= $this->getEvent()
            ->getApplication()
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getConnection();
        }

        return $this->_doctrineConnection;

    }

}
