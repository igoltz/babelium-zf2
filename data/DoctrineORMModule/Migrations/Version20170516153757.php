<?php

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170516153757 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE exercise_like DROP FOREIGN KEY fk_exercise_like_1');
        $this->addSql('ALTER TABLE exercise_like DROP FOREIGN KEY fk_exercise_like_2');
        $this->addSql('ALTER TABLE exercise_like CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE `like` `like` TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE exercise_like ADD CONSTRAINT FK_F546220180C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE exercise_like ADD CONSTRAINT FK_F54622015741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercise_descriptor CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE situation situation TINYINT(1) NOT NULL, CHANGE level level TINYINT(1) NOT NULL, CHANGE competence competence TINYINT(1) NOT NULL, CHANGE number number INT NOT NULL, CHANGE alte alte TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY fk_exercises_1');
        $this->addSql('ALTER TABLE exercise CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE exercisecode exercisecode VARCHAR(255) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE language language VARCHAR(45) NOT NULL, CHANGE difficulty difficulty INT NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE visible visible TINYINT(1) NOT NULL, CHANGE fk_scope_id fk_scope_id INT NOT NULL, CHANGE timecreated timecreated INT NOT NULL, CHANGE timemodified timemodified INT NOT NULL, CHANGE type type INT NOT NULL, CHANGE licence licence VARCHAR(60) NOT NULL, CHANGE likes likes INT NOT NULL, CHANGE dislikes dislikes INT NOT NULL, CHANGE ismodel ismodel TINYINT(1) NOT NULL, CHANGE model_id model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY fk_rel_exercise_descriptor_1');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY fk_rel_exercise_descriptor_2');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY fk_rel_exercise_descriptor_1');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY fk_rel_exercise_descriptor_2');
        $this->addSql('ALTER TABLE rel_exercise_descriptor CHANGE fk_exercise_id fk_exercise_id INT NOT NULL, CHANGE fk_exercise_descriptor_id fk_exercise_descriptor_id INT NOT NULL');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT FK_F45B5F7680C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT FK_F45B5F764166EEDD FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id)');
        $this->addSql('DROP INDEX fk_rel_exercise_descriptor_1 ON rel_exercise_descriptor');
        $this->addSql('CREATE INDEX IDX_F45B5F7680C2392E ON rel_exercise_descriptor (fk_exercise_id)');
        $this->addSql('DROP INDEX fk_rel_exercise_descriptor_2 ON rel_exercise_descriptor');
        $this->addSql('CREATE INDEX IDX_F45B5F764166EEDD ON rel_exercise_descriptor (fk_exercise_descriptor_id)');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT fk_rel_exercise_descriptor_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT fk_rel_exercise_descriptor_2 FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY fk_rel_exercise_tag_1');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY fk_rel_exercise_tag_2');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY fk_rel_exercise_tag_1');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY fk_rel_exercise_tag_2');
        $this->addSql('ALTER TABLE rel_exercise_tag CHANGE fk_exercise_id fk_exercise_id INT NOT NULL, CHANGE fk_tag_id fk_tag_id INT NOT NULL');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT FK_A3150E9780C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT FK_A3150E979A7C0B81 FOREIGN KEY (fk_tag_id) REFERENCES tag (id)');
        $this->addSql('DROP INDEX fk_rel_exercise_tag_1 ON rel_exercise_tag');
        $this->addSql('CREATE INDEX IDX_A3150E9780C2392E ON rel_exercise_tag (fk_exercise_id)');
        $this->addSql('DROP INDEX fk_rel_exercise_tag_2 ON rel_exercise_tag');
        $this->addSql('CREATE INDEX IDX_A3150E979A7C0B81 ON rel_exercise_tag (fk_tag_id)');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT fk_rel_exercise_tag_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT fk_rel_exercise_tag_2 FOREIGN KEY (fk_tag_id) REFERENCES tag (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY fk_assignment_2');
        $this->addSql('ALTER TABLE assignment CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_course_id fk_course_id INT DEFAULT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE duedate duedate BIGINT NOT NULL, CHANGE allowsubmissionsfromdate allowsubmissionsfromdate BIGINT NOT NULL, CHANGE grade grade BIGINT NOT NULL, CHANGE timemodified timemodified BIGINT NOT NULL, CHANGE maxattempts maxattempts INT NOT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA80C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE assignment_submission CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_assignment_id fk_assignment_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE timecreated timecreated BIGINT NOT NULL, CHANGE timemodified timemodified BIGINT NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE attempnumber attempnumber INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise_report CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE report_date report_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE evaluation_video DROP FOREIGN KEY FK_evaluation_video_1');
        $this->addSql('ALTER TABLE evaluation_video CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_evaluation_id fk_evaluation_id INT DEFAULT NULL, CHANGE thumbnail_uri thumbnail_uri VARCHAR(200) NOT NULL, CHANGE duration duration INT NOT NULL');
        $this->addSql('ALTER TABLE evaluation_video ADD CONSTRAINT FK_B930A7DD21262384 FOREIGN KEY (fk_evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY fk_rel_course_role_user_1');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY fk_rel_course_role_user_2');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY fk_rel_course_role_user_3');
        $this->addSql('ALTER TABLE rel_course_role_user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_course_id fk_course_id INT DEFAULT NULL, CHANGE fk_role_id fk_role_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE timemodified timemodified BIGINT NOT NULL');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT FK_754E709D38451E02 FOREIGN KEY (fk_course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT FK_754E709D262C1F80 FOREIGN KEY (fk_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT FK_754E709D5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_evaluation_1');
        $this->addSql('ALTER TABLE evaluation CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_response_id fk_response_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE score_overall score_overall TINYINT(1) DEFAULT NULL, CHANGE adding_date adding_date DATETIME DEFAULT NULL, CHANGE score_intonation score_intonation TINYINT(1) DEFAULT NULL, CHANGE score_fluency score_fluency TINYINT(1) DEFAULT NULL, CHANGE score_rhythm score_rhythm TINYINT(1) DEFAULT NULL, CHANGE score_spontaneity score_spontaneity TINYINT(1) DEFAULT NULL, CHANGE score_comprehensibility score_comprehensibility TINYINT(1) DEFAULT NULL, CHANGE score_pronunciation score_pronunciation TINYINT(1) DEFAULT NULL, CHANGE score_adequacy score_adequacy TINYINT(1) DEFAULT NULL, CHANGE score_range score_range TINYINT(1) DEFAULT NULL, CHANGE score_accuracy score_accuracy TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57592058474 FOREIGN KEY (fk_response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_response_2');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_response_3');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY fk_response_transcriptions1');
        $this->addSql('ALTER TABLE response CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_subtitle_id fk_subtitle_id INT DEFAULT NULL, CHANGE fk_transcription_id fk_transcription_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT NOT NULL, CHANGE fk_media_id fk_media_id INT DEFAULT NULL, CHANGE thumbnail_uri thumbnail_uri VARCHAR(200) NOT NULL, CHANGE duration duration INT NOT NULL, CHANGE priority_date priority_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB80C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB68F99600 FOREIGN KEY (fk_subtitle_id) REFERENCES subtitle (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBA01286E3 FOREIGN KEY (fk_transcription_id) REFERENCES transcription (id)');
        $this->addSql('ALTER TABLE media_rendition DROP FOREIGN KEY fk_media_rendition_1');
        $this->addSql('ALTER TABLE media_rendition CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_media_id fk_media_id INT DEFAULT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE filesize filesize INT NOT NULL');
        $this->addSql('ALTER TABLE media_rendition ADD CONSTRAINT FK_B2CD7137D8B79EAB FOREIGN KEY (fk_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE course CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fullname fullname VARCHAR(255) NOT NULL, CHANGE shortname shortname VARCHAR(255) NOT NULL, CHANGE startdate startdate BIGINT NOT NULL, CHANGE visible visible TINYINT(1) NOT NULL, CHANGE language language VARCHAR(45) NOT NULL, CHANGE timecreated timecreated BIGINT NOT NULL, CHANGE timemodified timemodified BIGINT NOT NULL');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_user_session_1');
        $this->addSql('ALTER TABLE user_session CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE session_id session_id VARCHAR(100) NOT NULL, CHANGE closed closed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDE5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tag CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE motd CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE displaywhenloggedin displaywhenloggedin TINYINT(1) NOT NULL, CHANGE code code VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE preferences CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_user_videohistory_1');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_user_videohistory_2');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_user_videohistory_3');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_user_videohistory_4');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_user_videohistory_5');
        $this->addSql('ALTER TABLE user_videohistory CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE fk_user_session_id fk_user_session_id INT DEFAULT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_response_id fk_response_id INT DEFAULT NULL, CHANGE fk_subtitle_id fk_subtitle_id INT DEFAULT NULL, CHANGE response_attempt response_attempt TINYINT(1) NOT NULL, CHANGE incidence_date incidence_date DATETIME NOT NULL, CHANGE subtitles_are_used subtitles_are_used TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_66124B075741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_66124B071FFB7E06 FOREIGN KEY (fk_user_session_id) REFERENCES user_session (id)');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_66124B0780C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_66124B0792058474 FOREIGN KEY (fk_response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_66124B0768F99600 FOREIGN KEY (fk_subtitle_id) REFERENCES subtitle (id)');
        $this->addSql('ALTER TABLE subtitle DROP FOREIGN KEY FK_exercise_subtitle_2');
        $this->addSql('ALTER TABLE subtitle DROP FOREIGN KEY fk_subtitle_media');
        $this->addSql('ALTER TABLE subtitle CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE fk_media_id fk_media_id INT DEFAULT NULL, CHANGE translation translation TINYINT(1) NOT NULL, CHANGE timecreated timecreated INT NOT NULL, CHANGE complete complete TINYINT(1) NOT NULL, CHANGE subtitle_count subtitle_count INT NOT NULL');
        $this->addSql('ALTER TABLE subtitle ADD CONSTRAINT FK_518597B15741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subtitle ADD CONSTRAINT FK_518597B1D8B79EAB FOREIGN KEY (fk_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE groups CHANGE coeval coeval VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE serviceconsumer_log CHANGE time time BIGINT NOT NULL, CHANGE method method VARCHAR(45) NOT NULL, CHANGE statuscode statuscode INT NOT NULL, CHANGE ipaddress ipaddress VARCHAR(45) NOT NULL, CHANGE origin origin VARCHAR(255) NOT NULL, CHANGE referer referer VARCHAR(255) NOT NULL, CHANGE fk_serviceconsumer_id fk_serviceconsumer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spinvox_request CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_transcription_id fk_transcription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transcription CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_credithistory_1');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_credithistory_2');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_credithistory_3');
        $this->addSql('ALTER TABLE credithistory CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_response_id fk_response_id INT DEFAULT NULL, CHANGE fk_eval_id fk_eval_id INT DEFAULT NULL, CHANGE changeAmount changeAmount INT NOT NULL');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_EFBF76A95741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_EFBF76A980C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_EFBF76A992058474 FOREIGN KEY (fk_response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE user_languages DROP FOREIGN KEY fk_user_id');
        $this->addSql('ALTER TABLE user_languages CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE level level INT NOT NULL, CHANGE positives_to_next_level positives_to_next_level INT NOT NULL, CHANGE purpose purpose VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_languages ADD CONSTRAINT FK_A031DE9D5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE serviceconsumer DROP FOREIGN KEY fk_moodle_api_1');
        $this->addSql('ALTER TABLE serviceconsumer CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE ipaddress ipaddress VARCHAR(255) NOT NULL, CHANGE subscriptionstart subscriptionstart BIGINT NOT NULL, CHANGE subscriptionend subscriptionend BIGINT NOT NULL, CHANGE notifyexpiration notifyexpiration TINYINT(1) NOT NULL, CHANGE timecreated timecreated BIGINT NOT NULL, CHANGE timemodified timemodified BIGINT NOT NULL, CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE serviceconsumer ADD CONSTRAINT FK_CB9784C65741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n DROP FOREIGN KEY fk_exercise_descriptor_i18n_1');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n CHANGE fk_exercise_descriptor_id fk_exercise_descriptor_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n ADD CONSTRAINT FK_13A7C7FE4166EEDD FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id)');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n ADD PRIMARY KEY (locale, fk_exercise_descriptor_id)');
        $this->addSql('ALTER TABLE exercise_comment DROP FOREIGN KEY FK_exercise_comments_1');
        $this->addSql('ALTER TABLE exercise_comment CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT DEFAULT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise_comment ADD CONSTRAINT FK_4E61A52980C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY fk_media_1');
        $this->addSql('ALTER TABLE media CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT DEFAULT NULL, CHANGE instanceid instanceid INT NOT NULL, CHANGE type type VARCHAR(45) NOT NULL, CHANGE timecreated timecreated INT NOT NULL, CHANGE timemodified timemodified INT NOT NULL, CHANGE duration duration INT NOT NULL, CHANGE level level TINYINT(1) NOT NULL, CHANGE defaultthumbnail defaultthumbnail INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE creditCount creditCount INT NOT NULL, CHANGE joiningDate joiningDate DATETIME NOT NULL, CHANGE active active TINYINT(1) NOT NULL, CHANGE isAdmin isAdmin TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE enrolment DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE enrolment CHANGE role role VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enrolment ADD PRIMARY KEY (fk_user_id, fk_group_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA80C2392E');
        $this->addSql('ALTER TABLE assignment CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_course_id fk_course_id INT UNSIGNED NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE duedate duedate BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE allowsubmissionsfromdate allowsubmissionsfromdate BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE grade grade BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE timemodified timemodified BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE maxattempts maxattempts INT UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT fk_assignment_2 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignment_submission CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_assignment_id fk_assignment_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE timecreated timecreated BIGINT DEFAULT 0 NOT NULL, CHANGE timemodified timemodified BIGINT DEFAULT 0 NOT NULL, CHANGE status status VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE attempnumber attempnumber INT UNSIGNED DEFAULT 0');
        $this->addSql('ALTER TABLE course CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fullname fullname VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE shortname shortname VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE startdate startdate BIGINT DEFAULT 0 NOT NULL, CHANGE visible visible TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE language language VARCHAR(45) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE timecreated timecreated BIGINT DEFAULT 0 NOT NULL, CHANGE timemodified timemodified BIGINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_EFBF76A95741EEB9');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_EFBF76A980C2392E');
        $this->addSql('ALTER TABLE credithistory DROP FOREIGN KEY FK_EFBF76A992058474');
        $this->addSql('ALTER TABLE credithistory CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_response_id fk_response_id INT UNSIGNED DEFAULT NULL, CHANGE fk_eval_id fk_eval_id INT UNSIGNED DEFAULT NULL, CHANGE changeAmount changeAmount INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_credithistory_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_credithistory_2 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE credithistory ADD CONSTRAINT FK_credithistory_3 FOREIGN KEY (fk_response_id) REFERENCES response (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enrolment DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE enrolment CHANGE role role VARCHAR(255) DEFAULT \'student\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE enrolment ADD PRIMARY KEY (fk_group_id, fk_user_id)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57592058474');
        $this->addSql('ALTER TABLE evaluation CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_response_id fk_response_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE score_overall score_overall TINYINT(1) DEFAULT \'0\', CHANGE adding_date adding_date DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE score_intonation score_intonation TINYINT(1) DEFAULT \'0\', CHANGE score_fluency score_fluency TINYINT(1) DEFAULT \'0\', CHANGE score_rhythm score_rhythm TINYINT(1) DEFAULT \'0\', CHANGE score_spontaneity score_spontaneity TINYINT(1) DEFAULT \'0\', CHANGE score_comprehensibility score_comprehensibility TINYINT(1) DEFAULT \'0\', CHANGE score_pronunciation score_pronunciation TINYINT(1) DEFAULT \'0\', CHANGE score_adequacy score_adequacy TINYINT(1) DEFAULT \'0\', CHANGE score_range score_range TINYINT(1) DEFAULT \'0\', CHANGE score_accuracy score_accuracy TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_evaluation_1 FOREIGN KEY (fk_response_id) REFERENCES response (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_video DROP FOREIGN KEY FK_B930A7DD21262384');
        $this->addSql('ALTER TABLE evaluation_video CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_evaluation_id fk_evaluation_id INT UNSIGNED NOT NULL, CHANGE thumbnail_uri thumbnail_uri VARCHAR(200) DEFAULT \'nothumb.png\' NOT NULL COLLATE utf8_general_ci, CHANGE duration duration INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE evaluation_video ADD CONSTRAINT FK_evaluation_video_1 FOREIGN KEY (fk_evaluation_id) REFERENCES evaluation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51C5741EEB9');
        $this->addSql('ALTER TABLE exercise CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL COMMENT \'Who suggested or uploaded this video\', CHANGE exercisecode exercisecode VARCHAR(255) NOT NULL COLLATE utf8_general_ci COMMENT \'In case it\'\'s Youtube video we\'\'ll store here it\'\'s uid\', CHANGE description description TEXT NOT NULL COLLATE utf8_general_ci COMMENT \'Describe the video\'\'s content\', CHANGE language language VARCHAR(45) NOT NULL COLLATE utf8_general_ci COMMENT \'The spoken language of this exercise\', CHANGE difficulty difficulty INT UNSIGNED NOT NULL COMMENT \'1: A1, 2: A2, 3: B1, 4: B2, 5: C\', CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'0: draft, 1: ready\', CHANGE visible visible TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'0: visible only to author, 1: visible in scope\', CHANGE fk_scope_id fk_scope_id INT UNSIGNED DEFAULT 1 NOT NULL, CHANGE timecreated timecreated INT DEFAULT 0 NOT NULL, CHANGE timemodified timemodified INT DEFAULT 0 NOT NULL, CHANGE type type INT DEFAULT 5 NOT NULL, CHANGE licence licence VARCHAR(60) DEFAULT \'cc-by\' NOT NULL COLLATE utf8_general_ci, CHANGE likes likes INT DEFAULT 0 NOT NULL, CHANGE dislikes dislikes INT DEFAULT 0 NOT NULL, CHANGE ismodel ismodel TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE model_id model_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT fk_exercises_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_comment DROP FOREIGN KEY FK_4E61A52980C2392E');
        $this->addSql('ALTER TABLE exercise_comment CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE exercise_comment ADD CONSTRAINT FK_exercise_comments_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_descriptor CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE situation situation TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE level level TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE competence competence TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE number number INT UNSIGNED DEFAULT 1 NOT NULL, CHANGE alte alte TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n DROP FOREIGN KEY FK_13A7C7FE4166EEDD');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n CHANGE fk_exercise_descriptor_id fk_exercise_descriptor_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n ADD CONSTRAINT fk_exercise_descriptor_i18n_1 FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_descriptor_i18n ADD PRIMARY KEY (fk_exercise_descriptor_id, locale)');
        $this->addSql('ALTER TABLE exercise_like DROP FOREIGN KEY FK_F546220180C2392E');
        $this->addSql('ALTER TABLE exercise_like DROP FOREIGN KEY FK_F54622015741EEB9');
        $this->addSql('ALTER TABLE exercise_like CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE `like` `like` TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE exercise_like ADD CONSTRAINT fk_exercise_like_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_like ADD CONSTRAINT fk_exercise_like_2 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_report CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE report_date report_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE groups CHANGE coeval coeval VARCHAR(255) DEFAULT \'FALSE\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C5741EEB9');
        $this->addSql('ALTER TABLE media CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE instanceid instanceid INT UNSIGNED NOT NULL, CHANGE type type VARCHAR(45) DEFAULT \'video\' NOT NULL COLLATE utf8_general_ci, CHANGE timecreated timecreated INT DEFAULT 0 NOT NULL, CHANGE timemodified timemodified INT DEFAULT 0 NOT NULL, CHANGE duration duration INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE level level TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'0: undefined, 1: primary, 2: model, 3: attempt, 4: raw\', CHANGE defaultthumbnail defaultthumbnail INT DEFAULT 1');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT fk_media_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_rendition DROP FOREIGN KEY FK_B2CD7137D8B79EAB');
        $this->addSql('ALTER TABLE media_rendition CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_media_id fk_media_id INT UNSIGNED NOT NULL, CHANGE status status TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'0: raw 1: encoding, 2: ready, 3: duplicate, 4: error\', CHANGE filesize filesize INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE media_rendition ADD CONSTRAINT fk_media_rendition_1 FOREIGN KEY (fk_media_id) REFERENCES media (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motd CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE displaywhenloggedin displaywhenloggedin TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE code code VARCHAR(45) DEFAULT NULL COLLATE utf8_general_ci COMMENT \'A numeric code to identify this particular message in different languages\'');
        $this->addSql('ALTER TABLE preferences CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY FK_754E709D38451E02');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY FK_754E709D262C1F80');
        $this->addSql('ALTER TABLE rel_course_role_user DROP FOREIGN KEY FK_754E709D5741EEB9');
        $this->addSql('ALTER TABLE rel_course_role_user CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_course_id fk_course_id INT UNSIGNED NOT NULL, CHANGE fk_role_id fk_role_id INT UNSIGNED NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE timemodified timemodified BIGINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT fk_rel_course_role_user_1 FOREIGN KEY (fk_course_id) REFERENCES course (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT fk_rel_course_role_user_2 FOREIGN KEY (fk_role_id) REFERENCES role (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_course_role_user ADD CONSTRAINT fk_rel_course_role_user_3 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY FK_F45B5F7680C2392E');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY FK_F45B5F764166EEDD');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY FK_F45B5F7680C2392E');
        $this->addSql('ALTER TABLE rel_exercise_descriptor DROP FOREIGN KEY FK_F45B5F764166EEDD');
        $this->addSql('ALTER TABLE rel_exercise_descriptor CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_exercise_descriptor_id fk_exercise_descriptor_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT fk_rel_exercise_descriptor_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT fk_rel_exercise_descriptor_2 FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_f45b5f7680c2392e ON rel_exercise_descriptor');
        $this->addSql('CREATE INDEX fk_rel_exercise_descriptor_1 ON rel_exercise_descriptor (fk_exercise_id)');
        $this->addSql('DROP INDEX idx_f45b5f764166eedd ON rel_exercise_descriptor');
        $this->addSql('CREATE INDEX fk_rel_exercise_descriptor_2 ON rel_exercise_descriptor (fk_exercise_descriptor_id)');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT FK_F45B5F7680C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE rel_exercise_descriptor ADD CONSTRAINT FK_F45B5F764166EEDD FOREIGN KEY (fk_exercise_descriptor_id) REFERENCES exercise_descriptor (id)');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY FK_A3150E9780C2392E');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY FK_A3150E979A7C0B81');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY FK_A3150E9780C2392E');
        $this->addSql('ALTER TABLE rel_exercise_tag DROP FOREIGN KEY FK_A3150E979A7C0B81');
        $this->addSql('ALTER TABLE rel_exercise_tag CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_tag_id fk_tag_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT fk_rel_exercise_tag_1 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT fk_rel_exercise_tag_2 FOREIGN KEY (fk_tag_id) REFERENCES tag (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_a3150e9780c2392e ON rel_exercise_tag');
        $this->addSql('CREATE INDEX fk_rel_exercise_tag_1 ON rel_exercise_tag (fk_exercise_id)');
        $this->addSql('DROP INDEX idx_a3150e979a7c0b81 ON rel_exercise_tag');
        $this->addSql('CREATE INDEX fk_rel_exercise_tag_2 ON rel_exercise_tag (fk_tag_id)');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT FK_A3150E9780C2392E FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id)');
        $this->addSql('ALTER TABLE rel_exercise_tag ADD CONSTRAINT FK_A3150E979A7C0B81 FOREIGN KEY (fk_tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB80C2392E');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB68F99600');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBA01286E3');
        $this->addSql('ALTER TABLE response CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_subtitle_id fk_subtitle_id INT UNSIGNED DEFAULT NULL, CHANGE fk_transcription_id fk_transcription_id INT UNSIGNED DEFAULT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE fk_media_id fk_media_id INT UNSIGNED DEFAULT NULL, CHANGE thumbnail_uri thumbnail_uri VARCHAR(200) DEFAULT \'nothumb.png\' NOT NULL COLLATE utf8_general_ci, CHANGE duration duration INT UNSIGNED NOT NULL, CHANGE priority_date priority_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_response_2 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_response_3 FOREIGN KEY (fk_subtitle_id) REFERENCES subtitle (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT fk_response_transcriptions1 FOREIGN KEY (fk_transcription_id) REFERENCES transcription (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE role CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) DEFAULT \'\' COLLATE utf8_general_ci, CHANGE description description VARCHAR(45) DEFAULT \'\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE serviceconsumer DROP FOREIGN KEY FK_CB9784C65741EEB9');
        $this->addSql('ALTER TABLE serviceconsumer CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE ipaddress ipaddress VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE subscriptionstart subscriptionstart BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE subscriptionend subscriptionend BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE notifyexpiration notifyexpiration TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE timecreated timecreated BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE timemodified timemodified BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE serviceconsumer ADD CONSTRAINT fk_moodle_api_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serviceconsumer_log CHANGE time time BIGINT UNSIGNED DEFAULT 0 NOT NULL, CHANGE method method VARCHAR(45) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE statuscode statuscode INT DEFAULT 500 NOT NULL, CHANGE ipaddress ipaddress VARCHAR(45) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE origin origin VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE referer referer VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, CHANGE fk_serviceconsumer_id fk_serviceconsumer_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE spinvox_request CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_transcription_id fk_transcription_id INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE subtitle DROP FOREIGN KEY FK_518597B15741EEB9');
        $this->addSql('ALTER TABLE subtitle DROP FOREIGN KEY FK_518597B1D8B79EAB');
        $this->addSql('ALTER TABLE subtitle CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE fk_media_id fk_media_id INT UNSIGNED NOT NULL, CHANGE translation translation TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE timecreated timecreated INT DEFAULT 0 NOT NULL, CHANGE complete complete TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE subtitle_count subtitle_count INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE subtitle ADD CONSTRAINT FK_exercise_subtitle_2 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subtitle ADD CONSTRAINT fk_subtitle_media FOREIGN KEY (fk_media_id) REFERENCES media (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transcription CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE creditCount creditCount INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE joiningDate joiningDate DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE active active TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE isAdmin isAdmin TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user_languages DROP FOREIGN KEY FK_A031DE9D5741EEB9');
        $this->addSql('ALTER TABLE user_languages CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE level level INT UNSIGNED NOT NULL COMMENT \'Level goes from 1 to 6. 7 used for mother tongue\', CHANGE positives_to_next_level positives_to_next_level INT UNSIGNED NOT NULL, CHANGE purpose purpose VARCHAR(255) DEFAULT \'practice\' NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE user_languages ADD CONSTRAINT fk_user_id FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDE5741EEB9');
        $this->addSql('ALTER TABLE user_session CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE session_id session_id VARCHAR(100) NOT NULL COLLATE utf8_general_ci COMMENT \'Value generated by PHPs builtin function\', CHANGE closed closed TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_user_session_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_66124B075741EEB9');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_66124B071FFB7E06');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_66124B0780C2392E');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_66124B0792058474');
        $this->addSql('ALTER TABLE user_videohistory DROP FOREIGN KEY FK_66124B0768F99600');
        $this->addSql('ALTER TABLE user_videohistory CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE fk_user_id fk_user_id INT UNSIGNED NOT NULL, CHANGE fk_user_session_id fk_user_session_id INT UNSIGNED NOT NULL, CHANGE fk_exercise_id fk_exercise_id INT UNSIGNED NOT NULL, CHANGE fk_response_id fk_response_id INT UNSIGNED DEFAULT NULL, CHANGE fk_subtitle_id fk_subtitle_id INT UNSIGNED DEFAULT NULL, CHANGE response_attempt response_attempt TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE incidence_date incidence_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE subtitles_are_used subtitles_are_used TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_user_videohistory_1 FOREIGN KEY (fk_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_user_videohistory_2 FOREIGN KEY (fk_user_session_id) REFERENCES user_session (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_user_videohistory_3 FOREIGN KEY (fk_exercise_id) REFERENCES exercise (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_user_videohistory_4 FOREIGN KEY (fk_response_id) REFERENCES response (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_videohistory ADD CONSTRAINT FK_user_videohistory_5 FOREIGN KEY (fk_subtitle_id) REFERENCES subtitle (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
