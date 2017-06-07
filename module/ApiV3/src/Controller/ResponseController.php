<?php

namespace ApiV3\Controller;

use Zend\Http\Response;

class ResponseController
    extends AbstractController
{

    public function get($id)
    {

        $responseRepo = $this->getDoctrineRepository('\ApiV3\Entity\Response');

        /**
         * @var \ApiV3\Entity\Response $response
         */
        $response = $responseRepo->find($id);
        if (empty($response)) {
            return $this->_notFound();
        }

        $exercise = $response->getFkExercise();
        $responsePk = $response->getId();

        $videoResponseUrl = sprintf(
            '%s/video-response/%s',
            $this->getBaseUrl(),
            $responsePk. '.mp4'
        );

        $result = array(
            'id' => $responsePk,
            'exerciseId' => $exercise->getId(),
            'exerciseTitle' => $exercise->getTitle(),
            'exerciseDescription' => $exercise->getDescription(),
            'exerciseId' => $exercise->getId(),
            'subtitleId' => $response->getFkSubtitle()->getId(),
            'mp4Url' => $videoResponseUrl
        );

        return $this->jsonResponse($result);

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
        $response->setAudio(0);

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

        $response->setAudio(1);
        $em->persist($response);
        $em->flush();

        return $this->jsonResponse($response);

    }

}
