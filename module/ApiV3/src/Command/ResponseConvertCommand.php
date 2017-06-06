<?php

namespace ApiV3\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ResponseConvertCommand extends Command
{

    /**
     * @var \Zend\Mvc\Application
     */
    protected $_zendApplication;

    /**
     * @var string
     */
    protected $_commandName = 'babelium:convert:response';

    protected $_formatProgress = '* [%bar%] %current%/%max% <fg=white;bg=blue>%elapsed:6s%/%estimated:-6s%</> %memory:6s%' . PHP_EOL;

    public function __construct(\Zend\Mvc\Application $application)
    {

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $this->_zendApplication = $application;

        parent::__construct($this->_commandName);

    }

    protected function configure()
    {

        $this->setName($this->_commandName)
            ->setDescription('Combinar audio y video original para generar la respuesta')
            ->setHelp('Ejecución en CRON');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Inicio');

        $where = array(
            'isProcessed' => 0,
            'audio' => 1
        );

        $responseList = $this->getResponseRepository()->findBy($where);
        if (empty($responseList)) {
            $output->writeln('No hay respuestas que procesar');
            return;
        }

        $count = sizeof($responseList);
        $output->writeln('Respuestas a procesar #' . $count);

        $generatePath = $this->_zendApplication
            ->getServiceManager()
            ->get('GeneratePath');

        $mediaPath    = STORAGE_PATH . '/media';
        $responsePath = STORAGE_PATH . '/response';

        /**
         * @var \ApiV3\Entity\Response $response
         */
        foreach ($responseList as $response) {

            $pathResponsePk = $generatePath->generate(
                $mediaPath,
                $response->getId(),
                false
            );

            $audioPath = $pathResponsePk . '/' . $response->getId() . '.wav';

            $exerciseId = $response->getFkExercise()->getId();

            $where = array(
                'instanceid' => $exerciseId
            );

            $exerciseMedia = $this->getMediaRepository()->findOneBy($where);

            $pathExerciseMediaPk = $generatePath->generate(
                $mediaPath,
                $exerciseMedia->getId(),
                false
            );

            $exerciseMediaPath = $pathExerciseMediaPk . '/' . $exerciseMedia->getId() . '.mp4';

            $mergeResponsePath = $pathResponsePk . '/' . $response->getId() . '.mp4';

            var_dump(file_exists($audioPath));
            var_dump(file_exists($exerciseMediaPath));
            var_dump(file_exists($mergeResponsePath));

            $cmd = sprintf(
                "%s -i %s -i %s -filter_complex 'amix=inputs=2' -c:a libmp3lame -q:a 4 -shortest -strict -2 -f mp4 %s",
                '/usr/bin/ffmpeg',
                $exerciseMediaPath,
                $audioPath,
                $mergeResponsePath
            );

            var_dump($cmd);
            die();

        }

        $output->write('Fin!');

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
    protected function getMediaRepository()
    {
        return $this->_zendApplication
            ->getServiceManager()
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository('\ApiV3\Entity\Media');
    }

}