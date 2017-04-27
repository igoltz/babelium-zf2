<?php

namespace ApiV3\Controller;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class ExercisesController
    extends AbstractController
{

    public function getList()
    {

        $exercises = $this->getService('ExercisesService')->getExercises();
        if (empty($exercises)) {
            return $this->_notFound();
        }

        $json = new JsonModel();
        $json->setVariables($exercises);
        $this->response->setStatusCode(200);

        return $json;

    }

    public function get($id)
    {

        $exercise = $this->getService('ExercisesService')->getExercise($id);
        if (empty($exercise)) {
            return $this->_notFound();
        }

        $json = new JsonModel();
        $json->setVariables($exercise);
        $this->response->setStatusCode(200);

        return $json;

    }

}
