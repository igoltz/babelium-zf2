<?php

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{

    /**
     * @var \Zend\Mvc\Application
     */
    protected $_zendApplication;

    /**
     * @var string
     */
    protected $_babeliumPathUploads;

    /**
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
            $mediaRend = $this->getMediaRenditionRepository()->findOneBy($criteria);
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

                $pathMediaPk = $generatePath->generate($mediaPath, $mediaRend->getId(), false);
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