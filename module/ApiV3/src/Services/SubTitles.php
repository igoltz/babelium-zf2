<?php

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
    public function parseSubtitles(array $subtitle = array())
    {
        return $this->parseSerializedSubtitles($subtitle['serialized_subtitles'], $subtitle['id']);
    }
        
    /**
     * Extrae los subtitulos en un array, para poder generar el un array que representa los subtítulos
     *
     * @param array $serializedSubtitle
     *         Información serializada de los subtitulos guardados en Base de datos.
     * @return array
     */
    public function parseSerializedSubtitles($serializedSubtitle, $subtitleId)
    {
        
        $parsedSubtitles = array();
        $distinctVoices = array();
        
        $serialized = $this->unpackblob($serializedSubtitle);
        
        //Sanitize string to strip non ASCII chars (non printable) to avoid json decode errors
        $cleanSerialized = preg_replace('/[\x00-\x1F\x80-\xFF]/', "", $serialized);
        $subtitles = \Zend\Json\Json::decode($cleanSerialized, true);
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
            
            $parsedSubtitles[] = $sline;
            
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