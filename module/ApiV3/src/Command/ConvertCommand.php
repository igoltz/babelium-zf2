<?php

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

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

    protected $_formatProgress = '* [%bar%] %current%/%max% <fg=white;bg=blue>%elapsed:6s%/%estimated:-6s%</> %memory:6s%' . PHP_EOL;

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

        $mediaList = $this->getMediaRenditionRepository()->findAll();

        $count = sizeof($mediaList);
        $output->writeln('Videos a convertir #' . $count);

        $bar = new ProgressBar($output, $count);
        $bar->setBarCharacter('<fg=green>=</>');
        $bar->setProgressCharacter('<fg=green>></>');
        $bar->setFormat($this->_formatProgress);

        $generatePath = $this->_zendApplication->getServiceManager()->get('GeneratePath');
        $mediaPath = STORAGE_PATH . '/media';

        $optionsFFMpeg = array(
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe'
        );
        $ffmpeg = \FFMpeg\FFMpeg::create($optionsFFMpeg);

        /**
         * @var \ApiV3\Entity\MediaRendition $media
         */
        foreach ($mediaList as $media) {

            $pk = $media->getId();

            $pathMediaPk = $generatePath->generate($mediaPath, $pk, false);
            mkdir($pathMediaPk, 0777, true);

            $bar->advance();

            $pathFile = sprintf(
                '%s/%s',
                $this->_babeliumPathUploads,
                $media->getFilename()
            );

            if (!file_exists($pathFile)) {
                continue;
            }

            $video = $ffmpeg->open($pathFile);
            $video
                ->save(new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'), $pathMediaPk . '/' . $pk . '.mp4')
                ->save(new \FFMpeg\Format\Video\WebM(), $pathMediaPk . '/' . $pk . '.webm');

        }

        $bar->finish();

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

}