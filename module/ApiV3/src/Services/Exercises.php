<?php

namespace ApiV3\Services;

//FIXME: is this class used at all?

class Exercises
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
     * Lista todos los ejercicios activos y visibles
     *
     * @return array
     */
    public function getExercises()
    {

        $columsPieces = array(
            'id',
            'title',
            'description',
            'language',
            'exercisecode as name',
            'from_unixtime(timecreated) as addingDate',
            'difficulty as avgDifficulty',
            'status',
            'likes',
            'dislikes',
            'type',
            'situation',
            'competence',
            'lingaspects'
        );

        $colums = implode(', ', $columsPieces);

        $select = sprintf(
            'SELECT %s FROM exercise WHERE status = 1 AND visible = 1 ORDER BY title ASC, language ASC',
            $colums
        );
        $params = array();

        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);
        $exercises = $stmt->fetchAll();

        if (empty($exercises)) {
            return array();
        }

       return $exercises;

    }

    /**
     * Buscar un ejercicio, segun el $id
     *
     * @param integer $id
     * @return array
     */
    public function getExercise($id)
    {

        $columsPieces = array(
            'e.id',
            'e.title',
            'e.description',
            'e.language',
            'e.exercisecode',
            'from_unixtime(e.timecreated) as addingDate',
            'u.username as userName',
            'e.difficulty as avgDifficulty',
            'e.status',
            'e.likes',
            'e.dislikes',
            'e.type',
            'e.competence',
            'e.situation',
            'e.lingaspects',
            'e.licence',
            'e.attribution',
            'e.visible'
        );

        $colums = implode(', ', $columsPieces);

        $select = sprintf(
            'SELECT %s FROM exercise e INNER JOIN user u ON e.fk_user_id = u.id WHERE e.id = :id',
            $colums
        );

        $params = array(
            'id' => $id
        );
        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);
        $exercise = $stmt->fetch();

        if (empty($exercise)) {
            return array();
        }

        $exercise['tags'] = $this->getExerciseTags($id);
        $exercise['descriptors'] = $this->getExerciseDescriptors($id);

        $media = $this->getExerciseMediaById($id);
        if (empty($media)) {
            return array();
        }

        $exercise['media'] = $media;

        return $exercise;

    }

    /**
     * Lista las etiquedas de un ejercicio
     *
     * @param integer $id
     * @return array
     */
    public function getExerciseTags($id)
    {

        $tags = array();
        $select = 'SELECT t.name FROM tag t INNER JOIN rel_exercise_tag r ON t.id = r.fk_tag_id WHERE r.fk_exercise_id = :exercise_id';

        $params = array(
            'exercise_id' => $id
        );
        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        $results = $stmt->fetchAll();
        if (empty($results)) {
            return $tags;
        }

        foreach ($results as $tag) {
            $tags[] = $tag['name'];
        }

        return $tags;

    }

    /**
     * Listas las descripciones de un ejercicio
     *
     * @param integer $id
     * @return array|string[]
     */
    public function getExerciseDescriptors($id)
    {

        $dcodes = array();
        $select = 'SELECT ed.* FROM rel_exercise_descriptor red INNER JOIN exercise_descriptor ed ON red.fk_exercise_descriptor_id = ed.id WHERE red.fk_exercise_id = :exercise_id';

        $params = array(
            'exercise_id' => $id
        );

        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        $results = $stmt->fetchAll();
        if (empty($results)) {
            return $dcodes;
        }

        foreach ($results as $result) {
            $dcode = sprintf(
                'D%d_%d_%02d_%d',
                $result['situation'],
                $result['level'],
                $result['competence'],
                $result['number']
            );
            $dcodes[] = $dcode;
        }

        return $dcodes;

    }

    /**
     * Obtiene la información del video de un ejercicio
     *
     * @param integer $id
     * @return array
     */
    public function getExerciseMediaById($id)
    {

        $columsPieces = array(
            'm.id',
            'm.mediacode',
            'm.instanceid',
            'm.component',
            'm.type',
            'm.duration',
            'm.level',
            'm.defaultthumbnail',
            'mr.status',
            'mr.filename',
            'MAX(sub.id) as subtitleId'
        );
        $colums = implode(', ', $columsPieces);

        $wherePieces = array(
            'm.instanceid = :instanceid',
            'm.component = "exercise"',
            'mr.status = 2',
            'm.level = 1'
        );
        $where = implode(' AND ', $wherePieces);

        $select = sprintf(
            'SELECT %s FROM media m INNER JOIN media_rendition mr ON m.id = mr.fk_media_id INNER JOIN subtitle sub ON sub.fk_media_id = m.id WHERE %s',
            $colums,
            $where
        );
        $params = array(
            'instanceid' => $id
        );

        //Get the latest subtitle version (last DB entry), see babelium standalone Subtitle.php, public function getSubtitleLines
        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        $results = $stmt->fetchAll();
        if (empty($results)) {
            return array();
        }

        $media = array();
        foreach ($results as $result) {

            $result['thumbnail'] = sprintf(
                '/resources/images/thumbs/%s/%02d.jpg',
                $result['mediacode'],
                $result['defaultthumbnail']
            );

            //FIXME:$result['netConnectionUrl'] = 'rtmp://babelium-server-dev.irontec.com/oflaDemo/';
            $result['mediaUrl'] = 'exercises/' . $result['filename'];
            $media[] = $result;
        }

        return $media;

    }

}