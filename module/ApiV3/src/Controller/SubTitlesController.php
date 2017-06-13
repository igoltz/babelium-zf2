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

use Zend\View\Model\JsonModel;
use Zend\Http\Response;

/**
 * Genera el vtt de subtítulos para los videos de ejercicios
 */
class SubTitlesController
    extends AbstractController
{

    /**
     * Obtiene la información relacionado con un subtitulo
     *
     * {@inheritDoc}
     * @see \ApiV3\Controller\AbstractController::get()
     */
    public function get($id)
    {

        $vtt = false;
        if (strpos($id, '.vtt') !== false) {
            $vtt = true;
            $id = str_replace('.vtt', '', $id);
        }

        $sql = 'SELECT * FROM subtitle where id = :id';

        $params = array(
            'id' => $id
        );
        $stmt= $this->getDoctrineConnection()->prepare($sql);
        $stmt->execute($params);

        $subtitle = $stmt->fetch();
        if (empty($subtitle)) {
            return $this->_notFound();
        }

        $subtService = $this->getService('SubTitlesService');
        $parseSubtitles = $subtService->parseSubtitles($subtitle);

        /**
         * Respuesta en formato JSON
         */
        if ($vtt === false) {
            $json = new JsonModel();
            $json->setVariables($parseSubtitles);
            $this->response->setStatusCode(200);
            return $json;

        }

        $fileContent = $subtService->generatoFileContent($parseSubtitles);

        $headers = new \Zend\Http\Headers();
        $headers->addHeaderLine('Content-Type:text/vtt;charset=utf-8');

        $response = new \Zend\Http\Response();
        $response->setContent($fileContent);
        $response->setHeaders($headers);

        return $response;

    }

}
