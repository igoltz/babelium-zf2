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

namespace ApiV3\Controller;

use SendFileToClient\SendFileToClient;

/**
 * Se carga el video de un ejercicio y se envia en multipart 206
 */
class MediaController
    extends AbstractController
{

    public function get($filename)
    {

        $id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

        $entity = '\ApiV3\Entity\MediaRendition';
        $mediaRenditionRepository = $this->getDoctrineRepository($entity);
        $mediaRendition = $mediaRenditionRepository->find($id);

        if (empty($mediaRendition)) {
            return $this->_notFound();
        }

        $config = new \ApiV3\Module();
        $config = $config->getConfig();

        $config['babelium']['path_uploads'];
        $mediaPath = STORAGE_PATH . '/media';

        $generatePath = $this->getService('GeneratePath')->generate(
            $mediaPath,
            $mediaRendition->getId(),
            false
        );

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
