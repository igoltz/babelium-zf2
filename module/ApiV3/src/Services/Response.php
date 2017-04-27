<?php

namespace ApiV3\Services;

class Response
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function __construct($container)
    {

        $this->_doctrineConnection = $container->get('Doctrine\ORM\EntityManager')->getConnection();
    }

    public function getResponse($id)
    {

        $select = sprintf(
            'SELECT r.*, u.username FROM response r INNER JOIN user u ON r.fk_user_id = u.id WHERE r.id = :id',
            $id
        );

        $params = array(
            'id' => $id
        );
        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        $results = $stmt->fetch();
        if (empty($results)) {
            return array();
        }

        return $results;

    }

}