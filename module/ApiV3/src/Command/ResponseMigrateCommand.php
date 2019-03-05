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
 * @author   Goethe-Institut e.V. - Immo Goltz
 * @license  GNU <http://www.gnu.org/licenses/>
 * @link     https://github.com/babeliumproject
 */

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Migrate old responses from flv into mp4, place in new path and adjust DB as api3 command babelium:convert:response would do
 */
class ResponseMigrateCommand extends Command
{

    /**
     * Zend Application
     *
     * @var \Zend\Mvc\Application
     */
    protected $_zendApplication;

    /**
     * Comando
     *
     * @var string
     */
    protected $_commandName = 'babelium:migrate:response';

    /**
     * Ruta donde se guardan los videos originales
     *
     * @var string
     */
    protected $_babeliumPathUploads;

    /**
     * Ruta del RED5
     *
     * @var string
     */
    protected $_babeliumPathRed;

    /**
     * Clase FFMpeg\FFMpeg para convinar el video y el audio
     *
     * @var FFMpeg\FFMpeg
     */
    protected $_ffmpeg;

    public function __construct(\Zend\Mvc\Application $application)
    {

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $this->_babeliumPathUploads = $config['babelium']['path_uploads'];
        $this->_babeliumPathRed = $config['babelium']['path_red5'];
        $this->_zendApplication = $application;


        $options = array(
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe'
        );

        $this->_ffmpeg = \FFMpeg\FFMpeg::create($options);

        parent::__construct($this->_commandName);

    }

    protected function configure()
    {

        $desc = 'Migrate old responses from flv into mp4, place in new path and adjust DB as api3 command babelium:convert:response would do';

        $this->setName($this->_commandName)
            ->setDescription($desc)
            ->setHelp('Run once to migrate old responses');

    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {

        $date = date('Y-m-d H:i:s');
        $output->writeln("Query DB for responses to convert ($date)");

        // api3 introduces these columns, they are set to 0 for existing (old) responses
        $where = array(
            'isConverted' => 0,
            'isProcessed' => 0,
            'audio' => 0,
        );

        // return newer responses first
        $order = array(
            'id' => 'DESC'
        );

        // return only this many entries
        $limit = null;
        $offset = null;

        /**
        Warning: this may consume a lot of memory!
        60.000 responses need memory_limit = 512M in php.ini
        Too small limit cause error like
        PHP Fatal error:  Allowed memory size of 134217728 bytes exhausted (tried to allocate 1179648 bytes) 
        in api3/vendor/doctrine/orm/lib/Doctrine/ORM/UnitOfWork.php on line 2568
        */
        $responseList = $this->getResponseRepository()->findBy($where, $order, $limit, $offset);
        if (empty($responseList)) {
            $output->writeln('No old responses found');
            return;
        }

        $countMax = sizeof($responseList);
        $output->writeln('Old responses found: ' . $countMax);
        $count = 1;

        $generatePath = $this->_zendApplication
            ->getServiceManager()
            ->get('GeneratePath');

        $mediaPath    = STORAGE_PATH . '/media';
        $responsePath = STORAGE_PATH . '/response';

        $em = $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager');

        /**
         * @var \ApiV3\Entity\Response $response
         */
        foreach ($responseList as $response) {

            $output->writeln("\nWorking on $count/$countMax");
            $output->writeln("responseId: " . $response->getId());
            $count++;

            // where to store the converted response
            $pathResponsePk = $generatePath->generate(
                $responsePath,
                $response->getId(),
                false
            );

            // get exercise id
            $exerciseId = $response->getFkExercise()->getId();
            $output->write("exerciseId: " . $exerciseId);

            // get media
            $where = array(
                'instanceid' => $exerciseId
            );
            $exerciseMedia = $this->getMediaRepository()->findOneBy($where);
            $output->write(", exerciseMediaId: " . $exerciseMedia->getId());

            // get media rendition of exercise
            // 'status' => 2: references the babelium converted flv
            // 'status' => 0: references the raw uploaded file, api3 has no entry but refer to it's own converted file via ID
            $where = array(
                'fkMedia' => $exerciseMedia->getId(),
                'status' => 0
            );
            $exerciseMediaRendition = $this->getMediaRenditionRepository()
                ->findOneBy($where);
            if ( !$exerciseMediaRendition) {
                $output->writeln("\nNo media rendition found for exercise, can't migrate");
                continue;                
            }
            $output->writeln(", exerciseMediaRenditionId: " . $exerciseMediaRendition->getId());

            // get api3 path to exercises
            $pathExerciseMediaPk = $generatePath->generate(
                $mediaPath,
                $exerciseMediaRendition->getId(),
                false
            );
            
            // already api3 converted exercise
            $exerciseMediaPath = sprintf(
                '%s/%s.mp4',
                $pathExerciseMediaPk,
                $exerciseMediaRendition->getId()
            );
            //$output->writeln("exerciseMediaPath: " . $exerciseMediaPath);
            if (!file_exists($exerciseMediaPath)) {
                $output->writeln("Exercise file $exerciseMediaPath not found, can't migrate");
                continue;
            }

            /** old exercise files have no h264 video stream
            // old flv exercise
            $exerciseOldMediaPath = sprintf(
                '%s/exercises/%s',
                $this->_babeliumPathRed,
                $exerciseMediaRendition->getFilename()
            );
            $output->writeln("exerciseOldMediaPath: " . $exerciseOldMediaPath);
            */

            // old response, merged flv file
            $oldResponsePath = sprintf(
                '%s/responses/%s_merge.flv',
                $this->_babeliumPathRed,
                $response->getFileIdentifier()
            );
            //$output->writeln("oldResponsePath: " . $oldResponsePath);

            if (!file_exists($oldResponsePath)) {
                $output->writeln("Response file $oldResponsePath not found, can't migrate");
                continue;
            }
           
            // get path for migrated response
            mkdir($pathResponsePk, 0775, true);
            $mergeResponsePath = sprintf(
                '%s/%s.mp4',
                $pathResponsePk,
                $response->getId()
            );
            //$output->writeln("mergeResponsePath: " . $mergeResponsePath);

            // merge video from already api3 converted exercise with audio from old response
            // -map 0:0 -map 1:0 -c copy : just copy the streams to be fast
            // note: audio in _merge.flv is stream 0
            // -y : force overwrite if output file exists
            $cmd = sprintf(
                "%s %s -i %s -i %s %s -f mp4 %s",
                '/usr/bin/ffmpeg',
                '-y -loglevel warning -stats',
                $exerciseMediaPath,
                $oldResponsePath,
                '-map 0:0 -map 1:0 -c copy',
                $mergeResponsePath
            );
           
            // as converting takes a _long_ time pre-run before real migration could keep downtime short
            if (file_exists($mergeResponsePath)) {
                $output->writeln("New response file $mergeResponsePath already exists, skipping ffmpeg");
            } else {
                $output->writeln("Execute [$cmd]");
                shell_exec($cmd);
            }
            
            # TODO: should this state not set once all is finished?
            # TODO: do we need flsuh here or could we persist as last step?
            // mark response converted if newly migrated response file exists
            if (file_exists($mergeResponsePath)) {
                $response->setIsConverted(1);
            }
            // mark response processed
            $response->setIsProcessed(1);

            $em->persist($response);
            $em->flush();

            $user = $this->getUserRepository()->find($response->getFkUserId());

            $video = $this->_ffmpeg->open($mergeResponsePath);

            $duration = floor($video->getFormat()->get('duration'));
            $filesize = $video->getFormat()->get('size');

            $metadata = json_encode($video->getFormat()->all(), true);

            # TODO: do we really need media DB entry?
            $media = new \ApiV3\Entity\Media();
            $media->setFkUser($user);
            $media->setComponent('response');
            $media->setType('video');
            $media->setLevel(1);
            $media->setDefaultthumbnail(1);
            $media->setTimecreated(time());
            $media->setTimemodified(0);

            $media->setMediacode($response->getFileIdentifier());
            $media->setInstanceid($response->getFkExercise()->getId());
            $media->setDuration($duration);
            $media->setIsConverted(1);
            $media->setIsProcessed(1);

            $em->persist($media);
            $em->flush();

            # TODO: do we really need mediaRendition DB entry?
            $mediaRendition = new \ApiV3\Entity\MediaRendition();
            $mediaRendition->setFkMedia($media);
            $mediaRendition->setTimecreated(time());
            $mediaRendition->setTimemodified(0);
            $mediaRendition->setStatus('2');
            $mediaRendition->setContenthash($response->getFileIdentifier());
            $mediaRendition->setFilesize($filesize);
            $mediaRendition->setMetadata($metadata);
            $mediaRendition->setDimension(720);
            $mediaRendition->setFilename(basename($mergeResponsePath));

            $em->persist($mediaRendition);
            $em->flush();

            $response->setFkMediaId($media->getId());
            $response->setDuration($duration);
            $em->persist($response);
            $em->flush();

            $output->writeln("Success.");

        }

        $output->writeln("\nMigration done.");
    }


    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getResponseRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\Response');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getUserRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\User');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getMediaRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\Media');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getMediaRenditionRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\MediaRendition');
    }
    
}
