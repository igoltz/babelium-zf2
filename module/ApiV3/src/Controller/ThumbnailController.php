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
 * Carga el thumbnail de los videos de ejercicios
 */
class ThumbnailController
    extends AbstractController
{

    public function get($id)
    {

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
            $config['babelium']['path_thumbs'],
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
