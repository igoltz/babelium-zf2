<?php

/*
based on improvequality.php from the original babelium developer (not part of any repo) and
Create.php from the main project
*/

if(!defined('BABELIUM_HOME')) define('BABELIUM_HOME', '/var/www/babelium');

require_once BABELIUM_HOME . 'services/utils/Config.php';
require_once BABELIUM_HOME . 'services/utils/Datasource.php';
require_once BABELIUM_HOME . 'services/utils/VideoProcessor.php';

require_once BABELIUM_HOME . '../scripts/MediaTask.php';
require_once 'Zend/Json.php';

const STATUS_UNDEF=0;
const STATUS_ENCODING=1;
const STATUS_READY=2;
const STATUS_DUPLICATED=3;
const STATUS_ERROR=4;

const LEVEL_UNDEF=0;
const LEVEL_PRIMARY=1;
const LEVEL_MODEL=2;

const EXERCISE_READY=1;
const EXERCISE_DRAFT=0;

const TYPE_VIDEO='video';
const TYPE_AUDIO='audio';

try{
	$CFG = new Config();
	$DB = new Datasource($CFG->host, $CFG->db_name, $CFG->db_username, $CFG->db_password);
	$VP = new VideoProcessor();
	$MT = new MediaTask();
	global $DB, $CFG, $VP, $MT;
	run_command($argv);
} catch (Exception $e) {
	echo ('Failed with ' . get_class($e) . ': ' . $e->getMessage()."\n");
}

function run_command($_argv) {
	if (!isset($_argv[1])) {
		usage();
	}
	$cmd = $_argv[1];
	$opts = array_slice($_argv, 2);

	if (!in_array($cmd, array('getExerciseList', 'fixMediaRendition'))) {
		usage();
	}

	if ($cmd === 'getExerciseList') {
		if(isset($opts[0])){
			$path_parts=pathinfo($opts[0]);
			if (is_writable($path_parts['dirname']) && $path_parts['extension'] == 'csv'){
				createCSV($opts[0]);
				return;
			} else {
					throw new Exception("The output file is not writable");
			}
		} else {
			throw new Exception('Output file was not specified');
		}
	}

	if ($cmd === 'fixMediaRendition') {
		if ( isset($opts[0]) ){
			if ( is_file($opts[0]) && is_readable($opts[0]) )  {
				reimportFiles($opts[0]);
				return;
			} else {
				throw new Exception("Input file $opts[0] not readable");
			}
		} else {
			throw new Exception('Input file was not specified');
		}
	}
}

function usage(){
	throw new Exception("Usage:\ngetExerciseList output.csv\nfixMediaRendition input.csv");
}

function createCSV($file){
	global $DB;

	$sql = "SELECT e.id, e.title, e.description, 'FILENAME', e.status, e.visible, m.id as mid, mr.id as mrid, mr.filename as mrfilename, mr.status as mrstatus
			FROM exercise e
			INNER JOIN media m ON e.id=m.instanceid
			INNER JOIN media_rendition mr ON m.id=mr.fk_media_id
			-- WHERE e.status=1
			-- just list every known exercise media
			";
	$data = $DB->_multipleSelect($sql);
	if(!$data){
		throw new Exception('Did not find any exercise');
	} else {
		$fh = fopen($file, 'w') or die("Can't open file");
		$header = array('id','title','description','filename','status','visible','m.id','mr.id','mr.filename','mr.status');
		fputcsv($fh, $header);
		foreach($data as $row){
			$assoc_row = (array) $row;
			$assoc_row['description'] = strip_tags($assoc_row['description']);
			$values = array_values($assoc_row);
			fputcsv($fh, $values);
		}
		fclose($fh);
	}
}



function reimportFiles($csvfile){
	global $CFG, $DB, $VP;

	$fh = fopen($csvfile, "r") or die("Can't open file");
	$row = 0;
	while(($data = fgetcsv($fh)) !== FALSE){
		if($row > 0){
			$num = count($data);
			$exerciseid = $data[0];
			$title = $data[1];
			$filename = $data[3];
			if($exerciseid){
				if(!empty($filename)){
					print("Reimport ID: $exerciseid, Title: $title, File: $filename\n");
					saveExerciseMedia($exerciseid, $filename);
					print("Done\n\n");
				} else {
					print("Error on row $row, Filename missing\n");
				}
			} else {
				print("Error on row $row, ID missing\n");
			}
		}
		$row++;
	}
	fclose($fh);
}



# workflow from Create.php / saveExerciseMedia
function saveExerciseMedia($exerciseid, $filename) {
	global $CFG, $DB, $VP, $MT;

	$filemedia = $CFG->filePath . '/' . $filename;
			
	if ( is_file($filemedia) ) {
		$medianfo = $VP->retrieveMediaInfo($filemedia);
		$dimension = $medianfo->videoHeight;
		$filesize = filesize($filemedia);			
	} else {
		print("\tError: New file $filename not found\n");
		return;
	}

	# we have exercise id and need media id
	$sql = "SELECT id FROM media WHERE instanceid=%d";
	$result = $DB->_singleSelect($sql, $exerciseid);
	if ( !$result ) {
		print("\tCouldn't select media id for exercise id $exerciseid\n");
		return;
	}
	$mediaid = $result->id;

	# now check if this media id has only 1 rendition
	$sql = "SELECT COUNT(fk_media_id) as mrc FROM media_rendition WHERE fk_media_id=%d";
	$result = $DB->_singleSelect($sql, $mediaid);
	if ( !$result ) {
		print("\tCouldn't select media rendition count for media_id $mediaid\n");
		return;
	}
	if ( $result->mrc != 1 ) {
		print("\tError: media rendition count for media_id $mediaid is $result->mrc, expected 1\n");
		return;
	}

	# get id of this rendition
	$sql_rendition = "SELECT id, filename, timecreated FROM media_rendition WHERE fk_media_id=%d";
	$rendition = $DB->_singleSelect($sql_rendition, $mediaid);
	if ( !$rendition ) {
		print("\tCouldn't select media rendition for id $mediaid\n");
		return;
	}

	$contenthash = $medianfo->hash;
	#$duration = $medianfo->duration;
	#$type = $medianfo->hasVideo ? 'video' : 'audio';
	$metadata = custom_json_encode($medianfo);


	# create rendition entry for file to reimport
	$insert_mr = "INSERT INTO media_rendition (fk_media_id, filename, contenthash, status, timecreated, timemodified, filesize, metadata, dimension) 
				  VALUES (%d, '%s', '%s', %d, %d, %d, %d, '%s', %d)";
	$mediarendition = $DB->_insert($insert_mr, $mediaid, $filename, $contenthash, STATUS_UNDEF, $rendition->timecreated, time(), $filesize, $metadata, $dimension);
	if(!$mediarendition) {
		print("\tError: Couldn't insert new media_rendition entry\n");
		return;
	}
	print("\tCreated new media_rendition id: $mediarendition\n");

	# select data for the new rendition
	$sql = "SELECT mr.id, mr.fk_media_id, mr.status, mr.filename, mr.timecreated, m.mediacode 
			FROM media_rendition mr
			INNER JOIN media m ON mr.fk_media_id=m.id 
			WHERE mr.id=%d";
	$mediarendition = $DB->_singleSelect($sql, $mediarendition);	

	# mark old entry with status error
	$sql = "UPDATE media_rendition SET status = %d WHERE id=%d";
	$result = $DB->_update($sql,STATUS_ERROR, $rendition->id);
	if($result) print("\tUpdated media_rendition status, id: $rendition->id\n");

	# mark media as unconverted/unprocessed
	# these fields exist only after api3 is installed
	$sql="SHOW COLUMNS FROM media LIKE '%s'";
	$result = $DB->_singleSelect($sql, 'is_converted');	
	if($result) {
		$sql = "UPDATE media SET is_converted=0, is_processed=0 WHERE id=%d";
		$result = $DB->_update($sql,$mediaid);
		if($result) print("\tUpdated media is_*, id: $mediaid\n");
	}

	# encode new rendition via MediaTask.php which also adjusts database entries
	print("\tConverting with MediaTask->processMediaFile()...\n");
	$result = $MT->processMediaFile($mediarendition);
	# now media should processed, error thrown on failure
	
	# remove old rendition entry from database
	$sql = "DELETE FROM media_rendition WHERE id=%d";
	$result = $DB->_delete($sql,$rendition->id);
	if($result) print("\tRemoved old media_rendition id: $rendition->id\n");

	# and old flash file from disk
	$exercisedir = $CFG->red5Path.'/exercises/';
	if ( unlink($exercisedir . $rendition->filename) ) {
		print("\tRemoved old media file from disk\n");
	} else {
		printf("\tError: Couldn't removed old media file %s from disk\n", $rendition->filename);
	}
}



# copied from Create.php
/**
 * Encode the given array using Json
 *
 * @param Array $data
 * @param bool $prettyprint
 * @return mixed $data
 */
function custom_json_encode($data, $prettyprint=0){
	$data = Zend_Json::encode($data,false);
	$data = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$match', 'return mb_convert_encoding(pack("H*", $match[1]), "UTF-8", "UCS-2BE");'), $data);
	if($prettyprint)
		$data = Zend_Json::prettyPrint($data);
	return $data;
}
