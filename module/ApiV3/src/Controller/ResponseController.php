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

        $whereMedia = array(
            'instanceid' => $exercise->getId(),
        );

        $mediaRepository = $this->getDoctrineRepository('\ApiV3\Entity\Media');
        $media = $mediaRepository->findOneBy($whereMedia);

        $thumbnailUrl = sprintf(
            '%s/thumbnail/%s/%02d.jpg',
            $this->getBaseUrl(),
            $media->getMediacode(),
            $media->getDefaultthumbnail()
        );

        $result = array(
            'id' => $responsePk,
            'exerciseId' => $exercise->getId(),
            'title' => $exercise->getTitle(),
            'description' => $exercise->getDescription(),
            'exerciseId' => $exercise->getId(),
            'subtitleId' => $response->getFkSubtitle()->getId(),
            'mp4Url' => $videoResponseUrl,
            'thumbnail' => $thumbnailUrl,
            'isProcessed' => $response->getIsProcessed(),
            'isConverted' => $response->getIsConverted()
        );

        return $this->jsonResponse($result);

    }

    public function create($data)
    {

        $exerciseId = $this->params()->fromPost('exerciseId', false);
        $subtitleId = $this->params()->fromPost('subtitleId', false);
        $characterName = $this->params()->fromPost('characterName', false);
        $audio = $this->params()->fromPost('audio', false);

        $entity = '\ApiV3\Entity\Exercise';
        $exerciseRepository = $this->getDoctrineRepository($entity);
        $exercise = $exerciseRepository->find($exerciseId);

        $entity = '\ApiV3\Entity\Subtitle';
        $subtitleRepository = $this->getDoctrineRepository($entity);
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
