<?php

namespace ApiV3\Controller;

class ExercisesController
    extends AbstractController
{

    public function getList()
    {

        $where = array(
            'status' => 1,
            'visible' => 1,
            'ismodel' => 0
        );
        $orderBy = array('title' => 'asc');

        /**
         * @var \Doctrine\ORM\EntityRepository $exercisesRepository
         */
        $exercisesRepository = $this->getDoctrineRepository('\ApiV3\Entity\Exercise');
        $exercises = $exercisesRepository->findBy($where, $orderBy);

        if (empty($exercises)) {
            return $this->_notFound();
        }

        return $this->jsonResponse($exercises, array('exercise-list'));

    }

    public function get($id)
    {

        $where = array(
            'status' => 1,
            'visible' => 1,
            'ismodel' => 0,
            'id' => $id
        );

        $exercisesRepository = $this->getDoctrineRepository('\ApiV3\Entity\Exercise');
        $exercise = $exercisesRepository->findOneBy($where);

        /**
         * @var \ApiV3\Entity\Exercise $exercise
         */
        if (empty($exercise)) {
            return $this->_notFound();
        }

        $whereMedia = array(
            'instanceid' => $exercise->getId(),
            'component' => 'exercise',
        );

        $mediaRepository = $this->getDoctrineRepository('\ApiV3\Entity\Media');
        $media = $mediaRepository->findOneBy($whereMedia);

        /**
         * @var \ApiV3\Entity\Media $media
         */
        if (empty($media)) {
            return $this->_notFound();
        }

        $whereMediaRendition = array(
            'fkMedia' => $media->getId(),
        );

        $mediaRenditionRepository = $this->getDoctrineRepository('\ApiV3\Entity\MediaRendition');
        $mediaRendition = $mediaRenditionRepository->findOneBy($whereMediaRendition);

        /**
         * @var \ApiV3\Entity\MediaRendition $mediaRendition
         */
        if (empty($mediaRendition)) {
            return $this->_notFound();
        }

        $whereSubtitle = array(
            'fkMedia' => $media->getId(),
        );

        $subtitleRepository = $this->getDoctrineRepository('\ApiV3\Entity\Subtitle');
        $subtitle = $subtitleRepository->findOneBy($whereSubtitle);

        /**
         * @var \ApiV3\Entity\Subtitle $subtitle
         */
        if (empty($subtitle)) {
            return $this->_notFound();
        }

        $thumbnailUrl = sprintf(
            '%s/thumbnail/%s/%02d.jpg',
            $this->getBaseUrl(),
            $media->getMediacode(),
            $media->getDefaultthumbnail()
        );

        $mediaUrl = sprintf(
            '%s/media/%s',
            $this->getBaseUrl(),
            $mediaRendition->getFilename()
        );

        $mediaResult = array(
            'id' => $media->getId(),
            'filename' => $mediaRendition->getFilename(),
            'subtitleId' => $subtitle->getId(),
            'thumbnail' => $thumbnailUrl,
            'mediaUrl' => $mediaUrl
        );

        $result = array(
            'id' => $exercise->getId(),
            'title' => $exercise->getTitle(),
            'description' => $exercise->getDescription(),
            'language' => $exercise->getLanguage(),
            'difficulty' => $exercise->getDifficulty(),
            'licence' => $exercise->getLicence(),
            'username' => $exercise->getFkUser()->getUsername(),
            'media' => $mediaResult
        );

        return $this->jsonResponse($result);

    }

}
