<?php

namespace ApiV3\Controller;

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class ResponseController
    extends AbstractController
{

    public function get($id)
    {

        $respService = $this->getService('ResponseService');

        $response = $respService->getResponse($id);
        if (empty($response)) {
            return $this->_notFound();
        }

        $exercise = $this->getService('ExercisesService')->getExercise($response['fk_exercise_id']);
        if (empty($exercise)) {
            return $this->_notFound();
        }

        $leftMedia = $exercise['media'];
        $rightMedia = array();
        $rightMedia['netConnectionUrl'] = 'rtmp://babelium-server-dev.irontec.com/oflaDemo/';
        $rightMedia['mediaUrl'] = 'responses/' . $response['file_identifier'] . '.flv';

        unset($exercise['media']);
        $exercise['leftMedia'] = $leftMedia;
        $exercise['rightMedia'] = $rightMedia;
        $exercise['subtitleId'] = $response['fk_subtitle_id'];
        $exercise['selectedRole'] = $response['character_name'];
        $exercise['mediaId'] = $response['fk_media_id'];

        $json = new JsonModel();
        $json->setVariables($exercise);
        $this->response->setStatusCode(200);

        return $json;

    }

}
