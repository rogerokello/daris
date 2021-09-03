<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $advancedlevelpointsawards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'lowestvalue' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,2', 'unsigned' => true),
		'highestvalue' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,2', 'unsigned' => true),
		'award' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $advancedlevelpointsawardsettings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'captoOforF9inanypaper' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $alevelmarksheetresults = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'class' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'stream' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'exam_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'year' => array('type' => 'text', 'null' => false, 'default' => null, 'length' => 4),
		'term' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'streamposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'totalpoints' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'CHEM_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CHEM1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'MTH1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'smth_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'smth_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'smth_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'HIST3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST6_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST6_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ECON1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE4_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE4_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART1_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART1_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART2_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART2_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART3_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART3_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ICT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ICT_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ICT_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GeP_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GeP_mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GeP_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $alevelreportdetails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $alevelreports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'year' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 4),
		'term' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classthen' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'streamthen' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'report_header_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'headteacherscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classteacherscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dormmasterscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dormmistresscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'streamposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'classposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'totalpoints' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'olevelreportdetail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'CHEM_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CHEM1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CHEM2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CHEM3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'MTH_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'MTH1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'MTH2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'smth_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'smth_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'smth_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'smth_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'HIST_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'HIST3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'HIST6_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST6_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST6_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ECON_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ECON1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ECON2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ECON2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE4_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE4_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE4_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART1_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART1_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART1_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART2_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART2_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART2_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART3_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART3_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART3_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ICT_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ICT_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ICT_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ICT_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GeP_finalgrade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GeP_finalaveragemark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GeP_finalaveragemarkgrade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GeP_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $alevelsubjectcombinations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'subject1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject4' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $classteachers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'names' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'class' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'stream' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'year' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $dependantdetails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'staffdetail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'childname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dateofbirth' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picturenumber' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $gradeprofiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'profilename' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $gradeprofileusesettings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'criterea' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $gradings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'lowestvalue' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'highestvalue' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'award' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'remarks' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $marksheetcritereas = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'examname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'class' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'year' => array('type' => 'text', 'null' => false, 'default' => null, 'length' => 4),
		'currenttimestamp' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $mutexrails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'creatingsheet' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'class' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'examname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'year' => array('type' => 'text', 'null' => false, 'default' => null, 'length' => 4),
		'updatingsheet' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $numbers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'currentyear' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'lastnumberused' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true),
		'classofissue' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'isused' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $olevelcompulsorysubjects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'year' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 4),
		'class' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'compulsorysubjects' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $olevelmarksheetresults = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'class' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'stream' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'exam_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'year' => array('type' => 'text', 'null' => false, 'default' => null, 'length' => 4),
		'term' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'totalmark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'averagemark' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'streamposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'aggregates' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'division' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENG' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENG_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CST' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CST_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'COMM' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'COMM_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PhE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PhE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'FRE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'FRE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LGO' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LGO_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'KIS' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'KIS_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $olevelreportdetails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'reportname' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'reportyear' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 4),
		'reportterm' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'reportclass' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'default_exams_considered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'comment' => 'This is the set of exams that will be used to generate the report', 'charset' => 'latin1'),
		'default_subjects_considered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2000, 'collate' => 'latin1_swedish_ci', 'comment' => 'the default subjects used to create the report', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $olevelreports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'year' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => 4),
		'term' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classthen' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'streamthen' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'report_header_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'headteacherscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'classteacherscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dormmasterscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dormmistresscomment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'streamposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'classposition' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'besteightaggregates' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'division' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 7, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'totalmark' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'olevelreportdetail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'ENG' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENG_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENG_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENG_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'CST' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CST_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CST_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CST_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'COMM' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'COMM_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'COMM_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'COMM_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'LIT' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LIT_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LIT_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'CRE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CRE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CRE_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'HIST' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'HIST_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'HIST_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'GEOG' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'GEOG_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'GEOG_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'MTH' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'MTH_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'MTH_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'AGRIC' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'AGRIC_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'AGRIC_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'PHY' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PHY_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PHY_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'CHEM' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'CHEM_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'CHEM_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'BIO' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'BIO_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'BIO_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'ART' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ART_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ART_datecreated' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'ENT' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ENT_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'ENT_datecreated' => array('type' => 'timestamp', 'null' => true, 'default' => null),
		'PhE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PhE_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'PhE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'PhE_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'FRE' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'FRE_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'FRE_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'FRE_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'LGO' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LGO_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'LGO_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'LGO_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'KIS' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'KIS_examsconsidered' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'KIS_grade' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'KIS_datecreated' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $ordinaryleveldivisionawards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'lowestvalue' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'highestvalue' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'award' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $ordinaryleveldivisionawardsettings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'gradeprofile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'getbestsubjects' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'nobestsubjectstoget' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'captodiv2forpassineng' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'captodiv2forF9inmaths' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'captodiv3forF9inenglish' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'shifttodiv7forlessthanbestnumberofsubjects' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'gradeusingtotalmark' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $pleresults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'english' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'mathematics' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'science' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'sst' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'aggregate' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'grade' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $previousworkplaces = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'staffdetail_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'organisation' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'responsiblilty' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'startdate' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'enddate' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'salaryscale' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'salaryscaleunits' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $profileassignments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'class' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'gradeprofile_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $registrationnumbers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'yearused' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'classused' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'lastnumberused' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'classlevel' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $schooldoneasubjects = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'),
		'fullsubjectname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shortsubjectname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subjectcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'papersdone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'issubsidiary' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $schooldoneexams = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'fullexamname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'startdate' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'enddate' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'termdone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'reportorder' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $schooldonesubjects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'fullsubjectname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shortsubjectname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subjectcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subjectgroup' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $schoolstreams = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'stream' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shortstreamname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $staffdetails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sex' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'age' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'maritalstatus' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'spousename' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'numberofchildren' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'numberofdependants' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'picturenumber' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'healthstatus' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tribe' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'homecountry' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'homedistrict' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nssfnumber' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dateofbirth' => array('type' => 'date', 'null' => true, 'default' => null),
		'accountdetails' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nextofkinname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nextofkincontacts' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentposition' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentresidentialvillage' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentresidentialsubcounty' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentresidentialcounty' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentresidentialdistrict' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currentresidentialcountry' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'phonenumbers' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'emailaddresses' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'studenthaspic' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picture' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1000, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'registrationnumber' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'availabilitystatus' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'joiningdate' => array('type' => 'date', 'null' => true, 'default' => null),
		'religion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'leavingdate' => array('type' => 'date', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $staffpicturenumbers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'currentyear' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'lastnumberused' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $students = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'An id which keeps on incrementing'),
		'registrationnumber' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'surname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'othernames' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'availabilitystatus' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sex' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nationality' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'religion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'birthdate' => array('type' => 'date', 'null' => false, 'default' => null),
		'currentclass' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'currentstream' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'studentrating' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'joiningdate' => array('type' => 'date', 'null' => false, 'default' => null),
		'village' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'parish' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subcounty' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'county' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'district' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mothername' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mothertelcontact' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mothercurrentresidence' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fathername' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fathertelcontact' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fathercurrentresidence' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'guardianname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'guardiantelcontact' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'guardiancurrentresidence' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nearestrelativename' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nearestrelativetelcontact' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nearestrelativecurrentresidence' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picture' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1000, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picturenumber' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'leavingdate' => array('type' => 'date', 'null' => true, 'default' => null),
		'fullnames' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'studenthaspic' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'currenttimestamp' => array('type' => 'timestamp', 'null' => false, 'default' => null),
		'studentpicture' => array('type' => 'binary', 'null' => true, 'default' => null),
		'leavingreason' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $uceresults = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'subject1name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject1mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject2name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject2mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject3name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject3mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject4name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject4mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject5name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject5mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject6name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject6mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject7name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject7mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject8name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject8mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject9name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject9mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'subject10name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subject10mark' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'aggregate' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'division' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $updatingflags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'updatingclass' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'updatestatus' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 1000, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'role' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

}
