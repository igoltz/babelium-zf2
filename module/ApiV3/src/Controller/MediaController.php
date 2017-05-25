<?php

namespace ApiV3\Controller;

use SendFileToClient\SendFileToClient;

class MediaController
extends AbstractController
{

    public function get($filename)
    {

        $id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

        $mediaRenditionRepository = $this->getDoctrineRepository('\ApiV3\Entity\MediaRendition');
        $mediaRendition = $mediaRenditionRepository->find($id);

        if (empty($mediaRendition)) {
            return $this->_notFound();
        }

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $config['babelium']['path_uploads'];
        $mediaPath = STORAGE_PATH . '/media';

        $generatePath = $this->getService('GeneratePath')->generate($mediaPath, $mediaRendition->getId(), false);

        $config = new \ApiV3\Module();
        $config = $config->getConfig();
        $path = sprintf(
            '%s/%s',
            $config['babelium']['path_uploads'],
            $mediaRendition->getFilename()
        );

        if (!file_exists($path)) {
            return $this->_notFound();
        }

        $fileName = $mediaRendition->getId() . '.mp4';

        $filePath = $generatePath . '/' . $fileName;

        $send = new SendFileToClient();
        $send->sendFile($filePath, $fileName);
        die();

    }

}
