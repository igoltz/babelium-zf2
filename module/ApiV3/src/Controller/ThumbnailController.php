<?php

namespace ApiV3\Controller;

use SendFileToClient\SendFileToClient;

class ThumbnailController
    extends AbstractController
{

    public function get($id)
    {

        /**
         * @var \Zend\Http\PhpEnvironment\Request $a
         */
        $uriString = $this->request->getUriString();
        $pieces = explode('/', $uriString);
        $thumbnail = end($pieces);

        $where = array('mediacode' => $id);

        $mediaRepository = $this->getDoctrineRepository('\ApiV3\Entity\Media');
        $media = $mediaRepository->findOneBy($where);

        if (empty($media)) {
            return $this->_notFound();
        }

        $config = new \ApiV3\Module();
        $config = $config->getConfig();
        $path = sprintf(
            '%s/%s/%s',
            $config['babelium']['path_uploads'],
            $id,
            $thumbnail
        );

        if (!file_exists($path)) {
            return $this->_notFound();
        }

        $send = new SendFileToClient();
        $send->sendFile($path, $thumbnail);
        die();

    }

}
