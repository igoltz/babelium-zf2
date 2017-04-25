<?php

namespace ApiV3\Services;

class Exercises
{
    protected $_streamingserver = 'rtmp://babelium-server-dev.irontec.com/oflaDemo/';
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $_doctrineConnection;

    public function __construct(
        \Doctrine\DBAL\Connection $doctrineConnection
    )
    {

        $this->_doctrineConnection = $doctrineConnection;

    }

    public function getExerciseById($id)
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
            return false;
        }

        $exercise['tags'] = $this->getExerciseTags($id);
        $exercise['descriptors'] = $this->getExerciseDescriptors($id);

        return $exercise;

    }

    public function getExerciseTags($exerciseId)
    {

        $tags = array();
        $select = 'SELECT t.name FROM tag t INNER JOIN rel_exercise_tag r ON t.id = r.fk_tag_id WHERE r.fk_exercise_id = :exercise_id';

        $params = array(
            'exercise_id' => $exerciseId
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

    public function getExerciseDescriptors($exerciseId)
    {

        $dcodes = array();
        $select = 'SELECT ed.* FROM rel_exercise_descriptor red INNER JOIN exercise_descriptor ed ON red.fk_exercise_descriptor_id = ed.id WHERE red.fk_exercise_id = :exercise_id';

        $params = array(
            'exercise_id' => $exerciseId
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

    public function getExerciseMedia($exerciseid)
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
            'mr.filename'
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
            'SELECT %s FROM media m INNER JOIN media_rendition mr ON m.id = mr.fk_media_id WHERE %s',
            $colums,
            $where
        );
        $params = array(
            'instanceid' => $exerciseid
        );

        $stmt = $this->_doctrineConnection->prepare($select);
        $stmt->execute($params);

        $results = $stmt->fetchAll();
        if (empty($results)) {
            return array();
        }

        $media = array();
        foreach ($results as $result) {
            $result['netConnectionUrl'] = $this->_streamingserver;
            $result['mediaUrl'] = 'exercises/' . $result['filename'];
            $media[] = $result;
        }

        return $media;

    }

}