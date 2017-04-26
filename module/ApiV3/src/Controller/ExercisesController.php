<?php

namespace ApiV3\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class ExercisesController
    extends AbstractRestfulController
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function getList()
    {

        $exerService = new \ApiV3\Services\Exercises(
            $this->getDoctrineConnection()
        );

        $exercises = $exerService->getExercises();
        if (empty($exercises)) {
            $json = new JsonModel();
            $this->response->setStatusCode(404);
            return $json;
        }

        $json = new JsonModel();
        $json->setVariables($exercises);
        $this->response->setStatusCode(200);

        return $json;

    }

    public function get($id)
    {

        $exerService = new \ApiV3\Services\Exercises(
            $this->getDoctrineConnection()
        );

        $exercise = $exerService->getExercise($id);
        if (empty($exercise)) {
            $json = new JsonModel();
            $this->response->setStatusCode(404);
            return $json;
        }

        $media = $exerService->getExerciseMediaById($id);
        if (empty($media)) {
            $json = new JsonModel();
            $this->response->setStatusCode(404);
            return $json;
        }

        $exercise['media'] = $media;

        $json = new JsonModel();
        $json->setVariables($exercise);
        $this->response->setStatusCode(200);

        return $json;

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
