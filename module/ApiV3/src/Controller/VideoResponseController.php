<?php

namespace ApiV3\Controller;

use SendFileToClient\SendFileToClient;

class VideoResponseController
    extends AbstractController
{

    public function get($filename)
    {

        $id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

        $responseRepo = $this->getDoctrineRepository('\ApiV3\Entity\Response');
        $response = $responseRepo->find($id);

        if (empty($response)) {
            return $this->_notFound();
        }

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $mediaPath = STORAGE_PATH . '/response';

        $generatePath = $this->getService('GeneratePath')->generate(
            $mediaPath,
            $response->getId(),
            false
        );

        $fileName = $response->getId() . '.mp4';
        $filePath = $generatePath . '/' . $fileName;

        if (!file_exists($filePath)) {
            return $this->_notFound();
        }

        $send = new SendFileToClient();
        $send->sendFile($filePath, $fileName);
        die();

    }

}
