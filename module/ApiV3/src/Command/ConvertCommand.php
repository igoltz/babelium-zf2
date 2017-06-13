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

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Esta clase es la encargada de convertir a mp4 los videos que se suben a
 * Babelium para ser usados en el modulos v3 de Moodle.
 */
class ConvertCommand extends Command
{

    /**
     * Zend Application
     *
     * @var \Zend\Mvc\Application
     */
    protected $_zendApplication;

    /**
     * Ruta donde se guardan los videos originales
     *
     * @var string
     */
    protected $_babeliumPathUploads;

    /**
     * Comando
     *
     * @var string
     */
    protected $_commandName = 'babelium:convert:videos';

    public function __construct(\Zend\Mvc\Application $application)
    {

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $this->_babeliumPathUploads = $config['babelium']['path_uploads'];
        $this->_zendApplication = $application;

        parent::__construct($this->_commandName);

    }

    protected function configure()
    {

        $this->setName($this->_commandName)
            ->setDescription('Importa y convierte los videos a mp4 y webm')
            ->setHelp('Importa los videos desde Babelium Server');

    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Convertir videos (mp4 - webm)');

        $where = array(
            'isProcessed' => 0
        );

        $mediaList = $this->getMediaRepository()->findBy($where);

        $count = sizeof($mediaList);
        $output->writeln('Videos a convertir #' . $count);

        $generatePath = $this->_zendApplication
            ->getServiceManager()
            ->get('GeneratePath');

        $mediaPath = STORAGE_PATH . '/media';

        $optionsFFMpeg = array(
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 15800,
            'ffmpeg.timeout'   => 15800,
            'ffprobe.timeout'  => 15800,
        );
        $ffmpeg = \FFMpeg\FFMpeg::create($optionsFFMpeg);

        $em = $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager');
        /**
         * @var \ApiV3\Entity\Media $media
         */
        foreach ($mediaList as $media) {

            $criteria = array(
                'fkMedia' => $media->getId()
            );
            $mediaRend = $this->getMediaRenditionRepository()->findOneBy(
                $criteria
            );

            if (empty($mediaRend)) {
                $media->setIsProcessed(1);
                $em->persist($media);
                $em->flush();
                continue;
            }

            $pathFile = sprintf(
                '%s/%s',
                $this->_babeliumPathUploads,
                $mediaRend->getFilename()
            );

            $media = $mediaRend->getFkMedia();
            $media->setIsProcessed(1);

            if (file_exists($pathFile)) {

                $pathMediaPk = $generatePath->generate(
                    $mediaPath,
                    $mediaRend->getId(), false
                );

                mkdir($pathMediaPk, 0777, true);

                $video = $ffmpeg->open($pathFile);
                $video->save(
                    new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'),
                    $pathMediaPk . '/' . $mediaRend->getId(). '.mp4'
                );

                $media->setIsConverted(1);

            }

            $em->persist($media);
            $em->flush();

        }

        $output->write('Terminado!');

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
    protected function getMediaRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\Media');
    }

}