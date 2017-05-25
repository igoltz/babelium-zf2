<?php

require __DIR__.'/vendor/autoload.php';

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

defined('STORAGE_PATH') || define(
    'STORAGE_PATH',
    realpath(dirname(__FILE__) . '/storage')
);

$previousDir = '.';

while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());

    if ($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is DoctrineModule in a subdir of your application skeleton?'
        );
    }

    $previousDir = $dir;
    chdir($dir);
}

$appConfig = include 'config/application.config.php';
if (file_exists('config/development.config.php')) {
    $appConfig = ArrayUtils::merge(
        $appConfig,
        include 'config/development.config.php'
    );
}

$zfApp = Application::init($appConfig);

$application = new Symfony\Component\Console\Application('Babelium', '0.0.1');
$convertCommand = new ApiV3\Command\ConvertCommand($zfApp);

$application->add($convertCommand);

//$application->setDefaultCommand($convertCommand->getName(), true);

$application->run();
