<?php

namespace ApiV3\Services;

class Consumers
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
     * En base a las 2 cabeceras de autenticación, se busca y valida el moodle
     *
     * @return mixed
     */
    public function getConsumerByHeaders(
        \Zend\Http\Headers $headers
    )
    {

        $accessKey = $headers->get('Access-Key')->getFieldValue();
        $secretAccess = $headers->get('Secret-Access')->getFieldValue();

        $wherePieces = array(
            'access_key = :access_key',
            'secret_access_key = :secret_access_key'
        );
        $where = implode(' AND ', $wherePieces);

        $select = sprintf('SELECT * FROM serviceconsumer WHERE %s', $where);

        $params = array(
            'access_key' => $accessKey,
            'secret_access_key' => $secretAccess
        );

        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        return $stmt->fetch();

    }

}