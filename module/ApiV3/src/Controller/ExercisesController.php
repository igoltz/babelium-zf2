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

class ExercisesController
    extends AbstractController
{

    public function getList()
    {

        $whereSql = array(
            'exercise.status = 1',
            'exercise.visible = 1',
            'exercise.ismodel = 0',
            'media.component = "exercise"',
            'media.is_converted = 1',
            'media.is_processed = 1'
        );

        $sql = sprintf(
            'SELECT exercise.id FROM exercise INNER JOIN %s WHERE %s',
            'media ON media.instanceid = exercise.id',
            implode(' AND ', $whereSql)
        );

        $prepare = $this->getEntityManager()->getConnection()->prepare($sql);
        $prepare->execute();
        $prepareResult = $prepare->fetchAll();

        if (empty($prepareResult)) {
            return $this->_notFound();
        }

        $exercisesIds = array();

        foreach ($prepareResult as $value) {
            $exercisesIds[] = $value['id'];
        }

        $where = array(
            'id' => $exercisesIds
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
            'isConverted' => 1,
            'isProcessed' => 1
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
        $orderBy = array('id' => 'desc');

        //Get the latest subtitle version (last DB entry), see babelium standalone Subtitle.php, public function getSubtitleLines
        $subtitleRepository = $this->getDoctrineRepository('\ApiV3\Entity\Subtitle');
        $subtitle = $subtitleRepository->findOneBy($whereSubtitle, $orderBy);

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
            $mediaRendition->getId() . '.mp4'
        );

        $result = array(
            'id' => $exercise->getId(),
            'title' => $exercise->getTitle(),
            'description' => $exercise->getDescription(),
            'language' => $exercise->getLanguage(),
            'difficulty' => $exercise->getDifficulty(),
            'licence' => $exercise->getLicence(),
            'username' => $exercise->getFkUser()->getUsername(),
            'media' => array(
                'id' => $media->getId(),
                'filename' => $mediaRendition->getId() . '.mp4',
                'subtitleId' => $subtitle->getId(),
                'thumbnail' => $thumbnailUrl,
                'mp4Url' => $mediaUrl
            )
        );

        return $this->jsonResponse($result);

    }

}
