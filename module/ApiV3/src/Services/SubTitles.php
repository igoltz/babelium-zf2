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
 * @author   Goethe-Institut e.V. - Immo Goltz
 * @license  GNU <http://www.gnu.org/licenses/>
 * @link     https://github.com/babeliumproject
 */

namespace ApiV3\Services;

class SubTitles
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function __construct($container)
    {
        $this->_doctrineConnection = $container
            ->get('Doctrine\ORM\EntityManager')
            ->getConnection();
    }

    /**
     * Devuelve los segundos de los subtitulos, en un formato correcto para
     * que lo interprete correctamente el archivo .vtt
     *
     * @param unknown $seconds
     * @return string
     */
    public function getFormatTimeBySeconds($seconds)
    {

        $values = explode('.', $seconds);
        $second = reset($values);

        $hideTime = new \DateTime("@$second");
        return $hideTime->format('H:i:s') . '.000';

    }

    /**
     * Extrae los subtitulos en un array, para poder generar el archivo .vtt
     *
     * @param array $subtitle
     *         Información de los subtitulos guardados en Base de datos.
     * @return array
     */
    public function parseSubtitles(array $subtitle = array(), $role = NULL)
    {
        return $this->parseSerializedSubtitles($subtitle['serialized_subtitles'], $subtitle['id'], $role);
    }
        
    /**
     * Extrae los subtitulos en un array, para poder generar el un array que representa los subtítulos
     *
     * @param array $serializedSubtitle
     *         Información serializada de los subtitulos guardados en Base de datos.
     * @return array
     */
    public function parseSerializedSubtitles($serializedSubtitle, $subtitleId, $role = NULL)
    {
        
        $parsedSubtitles = array();
        $distinctVoices = array();
        
        $serialized = $this->unpackblob($serializedSubtitle);
        
        $subtitles = \Zend\Json\Json::decode($serialized, true);
        foreach ($subtitles as $num => $data) {
            
            $sline = new \stdClass();
            $sline->id = $num;
            $sline->showTime = $data['start_time'] / 1000;
            $sline->hideTime = $data['end_time'] / 1000;
            $sline->text = $data['text'];
            
            $sline->exerciseRoleName = $data['meta']['voice'];
            $sline->subtitleId = $subtitleId;
            
            $c = count($distinctVoices);
            if (!array_key_exists($data['meta']['voice'], $distinctVoices)) {
                $distinctVoices[$data['meta']['voice']] = $c+1;
            }
            $sline->exerciseRoleId = $distinctVoices[$data['meta']['voice']];
            
            // return only the specified role
            // or all roles if role paramter is not set
            if (isset($role)) {
                if ($sline->exerciseRoleName === $role) {
                    $parsedSubtitles[] = $sline;
                }
            } else {
                $parsedSubtitles[] = $sline;
            }
            
        }
        
        return $parsedSubtitles;
        
    }

    /**
     * Genera el contenido para una respuesta en Formato .vtt
     *
     * @param array $parseSubtitles
     * @return string
     */
    public function generatoFileContent($parseSubtitles)
    {

        $vttFile = new \Captioning\Format\WebvttFile();
        foreach ($parseSubtitles as $lineSubtitle) {

            if ($lineSubtitle->exerciseRoleName === 'NPC') {
                $user = '<v NPC>';
            } else {
                $user = '<v Yourself>';
            }

            $vttFile->addCue(
                $user . $lineSubtitle->text . '</v>',
                $this->getFormatTimeBySeconds($lineSubtitle->showTime),
                $this->getFormatTimeBySeconds($lineSubtitle->hideTime)
            );

        }

        $vttFile->build();

        return $vttFile->getFileContent();

    }

    /**
     * Unserializes and uncompresses the given data.
     *
     * @param string $data
     *         Base64 encoded and compressed data.
     * @return string
     *         The decoded string or the original parameter if any decoding step was unsuccessful.
     */
    private function unpackblob($data)
    {
        if (($decoded = base64_decode($data)) !== FALSE) {
            if (($plaindata = gzuncompress($decoded)) !== FALSE) {
                return $plaindata;
            }
        }
        return $data;
    }

}