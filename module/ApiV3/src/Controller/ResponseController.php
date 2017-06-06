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

    public function create($data)
    {

        $studentId = $this->params()->fromPost('studentId', false);
        $exerciseId = $this->params()->fromPost('exerciseId', false);
        $subtitleId = $this->params()->fromPost('subtitleId', false);
        $characterName = $this->params()->fromPost('characterName', false);
        $responsehash = $this->params()->fromPost('responsehash', false);
        $audio = $this->params()->fromPost('audio', false);

        $exerciseRepository = $this->getDoctrineRepository('\ApiV3\Entity\Exercise');
        $exercise = $exerciseRepository->find($exerciseId);

        $subtitleRepository = $this->getDoctrineRepository('\ApiV3\Entity\Subtitle');
        $subtitle = $subtitleRepository->find($subtitleId);

        $consumer = $this->getService('ConsumerService')
            ->getConsumerByHeaders($this->request->getHeaders());

        $response = new \ApiV3\Entity\Response();

        $response->setIsPrivate(1);
        $response->setThumbnailUri('nothumb.png');
        $response->setRatingAmount(0);
        $response->setSource('Red5');
        $response->setDuration(0);
        $response->setFileIdentifier(uniqid('moodle-'));
        $response->setIsConverted(0);
        $response->setIsProcessed(0);

        $now = new \DateTime();

        $response->setAddingDate($now);
        $response->setPriorityDate($now);

        $response->setCharacterName($characterName);

        $response->setFkExercise($exercise);
        $response->setFkSubtitle($subtitle);

        $response->setFkUserId($consumer['fk_user_id']);

        $em = $this->getEntityManager();
        $em->persist($response);
        $em->flush();

        $pk = $response->getId();

        $generatePath = $this->getService('GeneratePath');

        $pathMediaPk = $generatePath->generate(
            STORAGE_PATH . '/response',
            $pk,
            false
        );
        mkdir($pathMediaPk, 0777, true);

        file_put_contents(
            $pathMediaPk . '/' . $pk . '.wav',
            base64_decode($audio)
        );

        return $this->jsonResponse($response);

    }

}
