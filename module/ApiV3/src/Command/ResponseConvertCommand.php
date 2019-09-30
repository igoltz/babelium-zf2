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
 * @author   Goethe-Institut e.V. - Immo Goltz
 * @license  GNU <http://www.gnu.org/licenses/>
 * @link     https://github.com/babeliumproject
 */

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Merge submitted audio with original video to generate response media
 */
class ResponseConvertCommand extends Command
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
    protected $_commandName = 'babelium:convert:response';

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

        $desc = 'Merge submitted audio with original video to generate response media';

        $this->setName($this->_commandName)
            ->setDescription($desc)
            ->setHelp('Run frequently via CRON');

    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {

        $date = date('Y-m-d H:i:s');
        $output->writeln("Query DB for responses to convert ($date)");

        $where = array(
            'isProcessed' => 0,
            'audio' => 1
        );

        $responseList = $this->getResponseRepository()->findBy($where);
        if (empty($responseList)) {
            $output->writeln('No responses found');
            return;
        }

        $countMax = sizeof($responseList);
        $output->writeln('Responses found: ' . $countMax);
        $count = 1;

        $generatePath = $this->_zendApplication
            ->getServiceManager()
            ->get('GeneratePath');

        $mediaPath    = STORAGE_PATH . '/media';
        $tmpPath    = sys_get_temp_dir();
        $responsePath = STORAGE_PATH . '/response';

        $responseConverted = array();

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

            $audioPath = sprintf(
                '%s/%s.wav',
                $pathResponsePk,
                $response->getId()
            );

            if (!file_exists($audioPath)) {
                $output->writeln("Response file $audioPath not found, can't convert");
                continue;
            }
            // TODO: check if audio file is not empty, has some duration (44 byte long files caused ffmpeg 3.4.2 to crash )

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
            $where = array(
                'fkMedia' => $exerciseMedia->getId()
            );
            $exerciseMediaRendition = $this->getMediaRenditionRepository()
                ->findOneBy($where);
            if ( !$exerciseMediaRendition) {
                $output->writeln("\nNo media rendition found for exercise, can't convert");
                continue;
            }
            $output->writeln(", exerciseMediaRenditionId: " . $exerciseMediaRendition->getId());

            // Get the latest subtitle version (last DB entry)
            $where = array(
                'fkMedia' => $exerciseMedia->getId(),
            );
            $orderBy = array('id' => 'desc');
            $exerciseSubtitle = $this->getSubtitleRepository()->findOneBy($where, $orderBy);

            $subtitleService = $this->_zendApplication->getServiceManager()->get('SubTitlesService');
            $decodedSubtitles = $subtitleService->parseSerializedSubtitles($exerciseSubtitle->getSerializedSubtitles(), $exerciseSubtitle->getId(), $response->getCharacterName());

            // if decodedSubtitles are empty try without specific role
            if ( count($decodedSubtitles) < 1 ) {
                $decodedSubtitles = $subtitleService->parseSerializedSubtitles($exerciseSubtitle->getSerializedSubtitles(), $exerciseSubtitle->getId());
            }

            $exerciseMutedMediaCommand = '';

            //Generar parámetros de control de volumen
            foreach ($decodedSubtitles as $key => $subtitle){
                $exerciseMutedMediaCommand .= "volume=enable='between(t,". $subtitle->showTime .",". $subtitle->hideTime .")':volume=0, ";
            }
            $exerciseMutedMediaCommand = substr($exerciseMutedMediaCommand, 0, -2);
            
            // get api3 path to exercises
            $pathExerciseMediaPk = $generatePath->generate(
                $mediaPath,
                $exerciseMediaRendition->getId(),
                false
            );

            $exerciseMediaPath = sprintf(
                '%s/%s.mp4',
                $pathExerciseMediaPk,
                $exerciseMediaRendition->getId()
            );
            $exerciseMutedMediaPath = sprintf(
                '%s/%s_mutted.mp4',
                $tmpPath,
                $exerciseMediaRendition->getId()
                );

            if (!file_exists($exerciseMediaPath)) {
                $output->writeln("Exercise file $exerciseMediaPath not found, can't convert");
                continue;
            }
            
            // generate exercise video with muted audio during subtitled parts
            $cmd = sprintf(
                "%s %s -i %s %s -af \"%s\" %s",
                '/usr/bin/ffmpeg',
                '-y -loglevel warning',
                $exerciseMediaPath,
                "-c:a libmp3lame -strict -2",
                $exerciseMutedMediaCommand,
                $exerciseMutedMediaPath
            );
            
            $output->writeln("Execute [$cmd]");
            shell_exec($cmd);
            
            $mergeResponsePath = sprintf(
                '%s/%s.mp4',
                $pathResponsePk,
                $response->getId()
            );

            if (!file_exists($exerciseMutedMediaPath)) {
                $output->writeln("Muted exercise file $exerciseMutedMediaPath not found, can't convert");
                continue;
            }

            // merge muted video with submitted audio
            $cmd = sprintf(
                "%s %s -i %s -i %s -filter_complex %s -f mp4 %s",
                '/usr/bin/ffmpeg',
                '-y -loglevel warning',
                $exerciseMutedMediaPath,
                $audioPath,
                "'amix=inputs=2' -c:a libmp3lame -q:a 4 -shortest -strict -2",
                $mergeResponsePath
            );
            
            $output->writeln("Execute [$cmd]");
            shell_exec($cmd);
            
            // mark response converted if newly converted response file exists
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

            $responseConverted[] = $response->getId();

            $response->setFkMediaId($media->getId());
            $response->setDuration($duration);
            $em->persist($response);
            $em->flush();

            $output->writeln("Success.");

        }

        $output->writeln("\nConversion done.");

        /** No need to store flash file versions
        $this->_sendToBabelium($output, $responseConverted);
        */

    }

    /**
     * Convierte el video combinado en flv para que se pueda reproducir en el
     * proyecto de Babelium
     *
     * @param OutputInterface $output
     * @param array $responseConverted
     */
    /** No need to store flash file versions
    protected function _sendToBabelium(
        OutputInterface $output,
        array $responseConverted = array()
    )
    {

        $output->writeln('Enviar respuestas a Babelium');

        $where = array(
            'id' => $responseConverted
        );

        $responses = $this->getResponseRepository()->findBy($where);
        if (empty($responses)) {
            return;
        }

        $output->writeln('Hay ' . sizeof($responses). ' para enviar');

        $generatePath = $this->_zendApplication
            ->getServiceManager()
            ->get('GeneratePath');

        $responsePath = STORAGE_PATH . '/response';
    */
        /**
         * @var \ApiV3\Entity\Response $response
         */
    /** No need to store flash file versions
        foreach ($responses as $response) {

            $pathResponsePk = $generatePath->generate(
                $responsePath,
                $response->getId(),
                false
            );

            $responseMerge = sprintf(
                '%s/%s.mp4',
                $pathResponsePk,
                $response->getId()
            );

            $responseNewPath = sprintf(
                '%s/responses/%s.flv',
                $this->_babeliumPathRed,
                $response->getFileIdentifier()
            );

            $command = sprintf(
                'ffmpeg -i %s -c:v libx264 -ar 22050 -crf 28 %s',
                $responseMerge,
                $responseNewPath
            );

            shell_exec($command);

            $output->writeln($responseNewPath);

        }

        $output->writeln('Fin');

    }
    */

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
    
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getSubtitleRepository()
    {
        return $this->_zendApplication
        ->getServiceManager()
        ->get('Doctrine\ORM\EntityManager')
        ->getRepository('\ApiV3\Entity\Subtitle');
    }
}
