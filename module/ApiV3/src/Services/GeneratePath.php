<?php

namespace ApiV3\Services;

class GeneratePath
{

    public function generate($docsRoot, $id, $checkExists = true)
    {

        $aId = str_split((string)$id);
        array_pop($aId);
        if (!sizeof($aId)) {
            $aId = array('0');
        }
        $aId[] = $id;
        $filePath = $docsRoot . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $aId);

        if ($checkExists) {
            if (is_file($filePath)) {
                return realpath($filePath);
            }
        } else {
            return $filePath;
        }

        return null;

    }

}
