

DROP TABLE IF EXISTS `daris`.`advancedlevelpointsawards`;
DROP TABLE IF EXISTS `daris`.`advancedlevelpointsawardsettings`;
DROP TABLE IF EXISTS `daris`.`alevelmarksheetresults`;
DROP TABLE IF EXISTS `daris`.`alevelreports`;
DROP TABLE IF EXISTS `daris`.`alevelsubjectcombinations`;
DROP TABLE IF EXISTS `daris`.`classteachers`;
DROP TABLE IF EXISTS `daris`.`dependantdetails`;
DROP TABLE IF EXISTS `daris`.`gradeprofiles`;
DROP TABLE IF EXISTS `daris`.`gradeprofileusesettings`;
DROP TABLE IF EXISTS `daris`.`gradings`;
DROP TABLE IF EXISTS `daris`.`marksheetcritereas`;
DROP TABLE IF EXISTS `daris`.`mutexrails`;
DROP TABLE IF EXISTS `daris`.`numbers`;
DROP TABLE IF EXISTS `daris`.`olevelcompulsorysubjects`;
DROP TABLE IF EXISTS `daris`.`olevelmarksheetresults`;
DROP TABLE IF EXISTS `daris`.`olevelreportdetails`;
DROP TABLE IF EXISTS `daris`.`olevelreports`;
DROP TABLE IF EXISTS `daris`.`ordinaryleveldivisionawards`;
DROP TABLE IF EXISTS `daris`.`ordinaryleveldivisionawardsettings`;
DROP TABLE IF EXISTS `daris`.`pleresults`;
DROP TABLE IF EXISTS `daris`.`previousworkplaces`;
DROP TABLE IF EXISTS `daris`.`profileassignments`;
DROP TABLE IF EXISTS `daris`.`registrationnumbers`;
DROP TABLE IF EXISTS `daris`.`schooldoneasubjects`;
DROP TABLE IF EXISTS `daris`.`schooldoneexams`;
DROP TABLE IF EXISTS `daris`.`schooldonesubjects`;
DROP TABLE IF EXISTS `daris`.`schoolstreams`;
DROP TABLE IF EXISTS `daris`.`staffdetails`;
DROP TABLE IF EXISTS `daris`.`staffpicturenumbers`;
DROP TABLE IF EXISTS `daris`.`students`;
DROP TABLE IF EXISTS `daris`.`uceresults`;
DROP TABLE IF EXISTS `daris`.`updatingflags`;
DROP TABLE IF EXISTS `daris`.`users`;


CREATE TABLE `daris`.`advancedlevelpointsawards` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) UNSIGNED NOT NULL,
	`lowestvalue` decimal(10,2) UNSIGNED DEFAULT NULL,
	`highestvalue` decimal(10,2) UNSIGNED DEFAULT NULL,
	`award` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`weight` int(11) UNSIGNED DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`advancedlevelpointsawardsettings` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) UNSIGNED NOT NULL,
	`captoOforF9inanypaper` tinyint(1) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`alevelmarksheetresults` (
	`id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`student_id` int(10) UNSIGNED NOT NULL,
	`class` int(11) NOT NULL,
	`stream` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`exam_name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`year` text(4) NOT NULL,
	`term` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classposition` int(11) DEFAULT NULL,
	`streamposition` int(11) DEFAULT NULL,
	`totalpoints` int(11) DEFAULT NULL,
	`chem_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`chem1_mark` int(11) UNSIGNED DEFAULT NULL,
	`chem1_grade` int(11) UNSIGNED DEFAULT NULL,
	`chem2_mark` int(11) UNSIGNED DEFAULT NULL,
	`chem2_grade` int(11) UNSIGNED DEFAULT NULL,
	`chem3_mark` int(11) UNSIGNED DEFAULT NULL,
	`chem3_grade` int(11) UNSIGNED DEFAULT NULL,
	`phy_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phy1_mark` int(11) UNSIGNED DEFAULT NULL,
	`phy1_grade` int(11) UNSIGNED DEFAULT NULL,
	`phy2_mark` int(11) UNSIGNED DEFAULT NULL,
	`phy2_grade` int(11) UNSIGNED DEFAULT NULL,
	`phy3_mark` int(11) UNSIGNED DEFAULT NULL,
	`phy3_grade` int(11) UNSIGNED DEFAULT NULL,
	`bio_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`bio1_mark` int(11) UNSIGNED DEFAULT NULL,
	`bio1_grade` int(11) UNSIGNED DEFAULT NULL,
	`bio2_mark` int(11) UNSIGNED DEFAULT NULL,
	`bio2_grade` int(11) UNSIGNED DEFAULT NULL,
	`bio3_mark` int(11) UNSIGNED DEFAULT NULL,
	`bio3_grade` int(11) UNSIGNED DEFAULT NULL,
	`mth_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`mth1_mark` int(11) UNSIGNED DEFAULT NULL,
	`mth1_grade` int(11) UNSIGNED DEFAULT NULL,
	`mth2_mark` int(11) UNSIGNED DEFAULT NULL,
	`mth2_grade` int(11) UNSIGNED DEFAULT NULL,
	`ict_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ict_mark` int(11) UNSIGNED DEFAULT NULL,
	`ict_grade` int(11) UNSIGNED DEFAULT NULL,
	`smth_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`smth_mark` int(11) UNSIGNED DEFAULT NULL,
	`smth_grade` int(11) UNSIGNED DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`alevelreports` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`student_id` int(11) UNSIGNED NOT NULL,
	`year` text(4) DEFAULT NULL,
	`term` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classthen` int(11) DEFAULT NULL,
	`streamthen` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`report_header_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`headteacherscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classteacherscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dormmasterscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dormmistresscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`streamposition` int(11) DEFAULT NULL,
	`classposition` int(11) DEFAULT NULL,
	`totalpoints` int(11) DEFAULT NULL,
	`olevelreportdetail_id` int(10) NOT NULL,
	`chem_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`chem1_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`chem1_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`chem1_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`chem2_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`chem2_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`chem2_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`chem3_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`chem3_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`chem3_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phy_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phy1_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`phy1_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`phy1_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phy2_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`phy2_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`phy2_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phy3_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`phy3_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`phy3_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`bio_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`bio1_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`bio1_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`bio1_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`bio2_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`bio2_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`bio2_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`bio3_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`bio3_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`bio3_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`mth_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`mth1_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`mth1_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`mth1_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`mth2_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`mth2_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`mth2_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ict_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ict_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`ict_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`ict_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`smth_finalgrade` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`smth_finalaveragemark` int(11) UNSIGNED DEFAULT NULL,
	`smth_finalaveragemarkgrade` int(11) UNSIGNED DEFAULT NULL,
	`smth_examsconsidered` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`alevelsubjectcombinations` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`student_id` int(11) NOT NULL,
	`subject1` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject2` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject3` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject4` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`classteachers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8mb4,
	COLLATE=utf8mb4_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`dependantdetails` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`staffdetail_id` int(11) UNSIGNED NOT NULL,
	`childname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dateofbirth` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`picturenumber` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`gradeprofiles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`profilename` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`gradeprofileusesettings` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) UNSIGNED NOT NULL,
	`criterea` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`gradings` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) NOT NULL,
	`lowestvalue` float DEFAULT NULL,
	`highestvalue` float DEFAULT NULL,
	`award` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`remarks` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`marksheetcritereas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`examname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`class` int(11) NOT NULL,
	`year` text(4) NOT NULL,
	`currenttimestamp` timestamp NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`mutexrails` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`creatingsheet` int(11) NOT NULL DEFAULT 0,
	`class` int(11) NOT NULL,
	`examname` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`year` text(4) NOT NULL,
	`updatingsheet` int(11) NOT NULL DEFAULT 0,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`numbers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`currentyear` int(11) NOT NULL,
	`lastnumberused` bigint(20) UNSIGNED NOT NULL,
	`classofissue` int(11) DEFAULT NULL,
	`isused` tinyint(1) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`olevelcompulsorysubjects` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`year` text(4) DEFAULT NULL,
	`class` int(11) DEFAULT NULL,
	`compulsorysubjects` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`olevelmarksheetresults` (
	`id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`student_id` int(10) UNSIGNED NOT NULL,
	`class` int(11) NOT NULL,
	`stream` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`exam_name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`year` text(4) NOT NULL,
	`term` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classposition` int(11) DEFAULT NULL,
	`totalmark` int(11) DEFAULT NULL,
	`averagemark` float DEFAULT NULL,
	`streamposition` int(11) DEFAULT NULL,
	`aggregates` int(11) DEFAULT NULL,
	`division` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ENG` int(11) UNSIGNED DEFAULT NULL,
	`ENG_grade` int(11) UNSIGNED DEFAULT NULL,
	`CST` int(11) UNSIGNED DEFAULT NULL,
	`CST_grade` int(11) UNSIGNED DEFAULT NULL,
	`COMM` int(11) UNSIGNED DEFAULT NULL,
	`COMM_grade` int(11) UNSIGNED DEFAULT NULL,
	`LIT` int(11) UNSIGNED DEFAULT NULL,
	`LIT_grade` int(11) UNSIGNED DEFAULT NULL,
	`CRE` int(11) UNSIGNED DEFAULT NULL,
	`CRE_grade` int(11) UNSIGNED DEFAULT NULL,
	`HIST` int(11) UNSIGNED DEFAULT NULL,
	`HIST_grade` int(11) UNSIGNED DEFAULT NULL,
	`GEOG` int(11) UNSIGNED DEFAULT NULL,
	`GEOG_grade` int(11) UNSIGNED DEFAULT NULL,
	`MTH` int(11) UNSIGNED DEFAULT NULL,
	`MTH_grade` int(11) UNSIGNED DEFAULT NULL,
	`AGRIC` int(11) UNSIGNED DEFAULT NULL,
	`AGRIC_grade` int(11) UNSIGNED DEFAULT NULL,
	`PHY` int(11) UNSIGNED DEFAULT NULL,
	`PHY_grade` int(11) UNSIGNED DEFAULT NULL,
	`CHEM` int(11) UNSIGNED DEFAULT NULL,
	`CHEM_grade` int(11) UNSIGNED DEFAULT NULL,
	`BIO` int(11) UNSIGNED DEFAULT NULL,
	`BIO_grade` int(11) UNSIGNED DEFAULT NULL,
	`ART` int(11) UNSIGNED DEFAULT NULL,
	`ART_grade` int(11) UNSIGNED DEFAULT NULL,
	`ENT` int(11) UNSIGNED DEFAULT NULL,
	`ENT_grade` int(11) UNSIGNED DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`olevelreportdetails` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`reportname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`reportyear` text(4) DEFAULT NULL,
	`reportterm` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`reportclass` int(11) UNSIGNED DEFAULT NULL,
	`default_exams_considered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'This is the set of exams that will be used to generate the report',
	`default_subjects_considered` varchar(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'the default subjects used to create the report',	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`olevelreports` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`student_id` int(11) UNSIGNED NOT NULL,
	`year` text(4) DEFAULT NULL,
	`term` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classthen` int(11) UNSIGNED DEFAULT NULL,
	`streamthen` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`report_header_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`headteacherscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`classteacherscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dormmasterscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dormmistresscomment` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`streamposition` int(10) UNSIGNED DEFAULT NULL,
	`classposition` int(10) UNSIGNED DEFAULT NULL,
	`besteightaggregates` int(10) UNSIGNED DEFAULT NULL,
	`division` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`totalmark` int(10) UNSIGNED DEFAULT NULL,
	`olevelreportdetail_id` int(11) UNSIGNED NOT NULL,
	`ENG` int(11) UNSIGNED DEFAULT NULL,
	`ENG_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ENG_grade` int(11) UNSIGNED DEFAULT NULL,
	`ENG_datecreated` timestamp NULL,
	`CST` int(11) UNSIGNED DEFAULT NULL,
	`CST_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`CST_grade` int(11) UNSIGNED DEFAULT NULL,
	`CST_datecreated` timestamp NULL,
	`COMM` int(11) UNSIGNED DEFAULT NULL,
	`COMM_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`COMM_grade` int(11) UNSIGNED DEFAULT NULL,
	`COMM_datecreated` timestamp NULL,
	`LIT` int(11) UNSIGNED DEFAULT NULL,
	`LIT_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`LIT_grade` int(11) UNSIGNED DEFAULT NULL,
	`LIT_datecreated` timestamp NULL,
	`CRE` int(11) UNSIGNED DEFAULT NULL,
	`CRE_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`CRE_grade` int(11) UNSIGNED DEFAULT NULL,
	`CRE_datecreated` timestamp NULL,
	`HIST` int(11) UNSIGNED DEFAULT NULL,
	`HIST_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`HIST_grade` int(11) UNSIGNED DEFAULT NULL,
	`HIST_datecreated` timestamp NULL,
	`GEOG` int(11) UNSIGNED DEFAULT NULL,
	`GEOG_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`GEOG_grade` int(11) UNSIGNED DEFAULT NULL,
	`GEOG_datecreated` timestamp NULL,
	`MTH` int(11) UNSIGNED DEFAULT NULL,
	`MTH_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`MTH_grade` int(11) UNSIGNED DEFAULT NULL,
	`MTH_datecreated` timestamp NULL,
	`AGRIC` int(11) UNSIGNED DEFAULT NULL,
	`AGRIC_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`AGRIC_grade` int(11) UNSIGNED DEFAULT NULL,
	`AGRIC_datecreated` timestamp NULL,
	`PHY` int(11) UNSIGNED DEFAULT NULL,
	`PHY_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`PHY_grade` int(11) UNSIGNED DEFAULT NULL,
	`PHY_datecreated` timestamp NULL,
	`CHEM` int(11) UNSIGNED DEFAULT NULL,
	`CHEM_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`CHEM_grade` int(11) UNSIGNED DEFAULT NULL,
	`CHEM_datecreated` timestamp NOT NULL,
	`BIO` int(11) UNSIGNED DEFAULT NULL,
	`BIO_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`BIO_grade` int(11) UNSIGNED DEFAULT NULL,
	`BIO_datecreated` timestamp NULL,
	`ART` int(11) UNSIGNED DEFAULT NULL,
	`ART_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ART_grade` int(11) UNSIGNED DEFAULT NULL,
	`ART_datecreated` timestamp NULL,
	`ENT` int(11) UNSIGNED DEFAULT NULL,
	`ENT_examsconsidered` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`ENT_grade` int(11) UNSIGNED DEFAULT NULL,
	`ENT_datecreated` timestamp NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`ordinaryleveldivisionawards` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) UNSIGNED NOT NULL,
	`lowestvalue` int(11) UNSIGNED DEFAULT NULL,
	`highestvalue` int(11) UNSIGNED DEFAULT NULL,
	`award` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`ordinaryleveldivisionawardsettings` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`gradeprofile_id` int(11) UNSIGNED NOT NULL,
	`getbestsubjects` tinyint(1) NOT NULL,
	`nobestsubjectstoget` int(11) UNSIGNED DEFAULT NULL,
	`captodiv2forpassineng` tinyint(1) NOT NULL,
	`captodiv2forF9inmaths` tinyint(1) NOT NULL,
	`captodiv3forF9inenglish` tinyint(1) NOT NULL,
	`shifttodiv7forlessthanbestnumberofsubjects` tinyint(1) NOT NULL,
	`gradeusingtotalmark` tinyint(1) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`pleresults` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`student_id` int(11) DEFAULT NULL,
	`english` int(11) DEFAULT NULL,
	`mathematics` int(11) DEFAULT NULL,
	`science` int(11) DEFAULT NULL,
	`sst` int(11) DEFAULT NULL,
	`aggregate` int(11) DEFAULT NULL,
	`grade` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`previousworkplaces` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`staffdetail_id` int(11) UNSIGNED DEFAULT NULL,
	`organisation` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`responsiblilty` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`startdate` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`enddate` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`salaryscale` int(11) UNSIGNED DEFAULT NULL,
	`salaryscaleunits` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`profileassignments` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`class` int(11) NOT NULL,
	`gradeprofile_id` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`registrationnumbers` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`yearused` int(11) DEFAULT NULL,
	`classused` int(11) DEFAULT NULL,
	`lastnumberused` int(11) DEFAULT NULL,
	`classlevel` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`schooldoneasubjects` (
	`id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`fullsubjectname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`shortsubjectname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subjectcode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`papersdone` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`issubsidiary` tinyint(1) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`schooldoneexams` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`fullexamname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`alias` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `reportorder` int(11) NOT NULL,
	`startdate` datetime DEFAULT NULL,
	`enddate` datetime DEFAULT NULL,
	`termdone` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`schooldonesubjects` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`fullsubjectname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`shortsubjectname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subjectcode` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subjectgroup` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`schoolstreams` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`stream` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`shortstreamname` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`staffdetails` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`sex` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`age` int(11) UNSIGNED DEFAULT NULL,
	`maritalstatus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`spousename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`numberofchildren` int(11) UNSIGNED DEFAULT NULL,
	`numberofdependants` int(11) UNSIGNED DEFAULT NULL,
	`picturenumber` int(11) UNSIGNED DEFAULT NULL,
	`healthstatus` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`tribe` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`homecountry` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`homedistrict` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`nssfnumber` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`dateofbirth` date DEFAULT NULL,
	`accountdetails` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`nextofkinname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`nextofkincontacts` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentposition` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentresidentialvillage` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentresidentialsubcounty` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentresidentialcounty` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentresidentialdistrict` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currentresidentialcountry` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`phonenumbers` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`emailaddresses` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`studenthaspic` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`picture` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`registrationnumber` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`availabilitystatus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`joiningdate` date DEFAULT NULL,
	`religion` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`leavingdate` date DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`staffpicturenumbers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`currentyear` int(11) NOT NULL,
	`lastnumberused` bigint(20) UNSIGNED NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`students` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'An id which keeps on incrementing',
	`registrationnumber` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`surname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`othernames` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`availabilitystatus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`sex` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`nationality` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`religion` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`birthdate` date NOT NULL,
	`currentclass` int(11) NOT NULL,
	`currentstream` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`studentrating` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`joiningdate` date NOT NULL,
	`village` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`parish` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`subcounty` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`county` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`district` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`mothername` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`mothertelcontact` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`mothercurrentresidence` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`fathername` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`fathertelcontact` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`fathercurrentresidence` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`guardianname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`guardiantelcontact` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`guardiancurrentresidence` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`nearestrelativename` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`nearestrelativetelcontact` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`nearestrelativecurrentresidence` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`picture` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`picturenumber` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`leavingdate` date DEFAULT NULL,
	`fullnames` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`studenthaspic` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`currenttimestamp` timestamp NOT NULL,
	`studentpicture` blob DEFAULT NULL,
	`leavingreason` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`uceresults` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`student_id` int(11) NOT NULL,
	`subject1name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject1mark` int(11) DEFAULT NULL,
	`subject2name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject2mark` int(11) DEFAULT NULL,
	`subject3name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject3mark` int(11) DEFAULT NULL,
	`subject4name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject4mark` int(11) DEFAULT NULL,
	`subject5name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject5mark` int(11) DEFAULT NULL,
	`subject6name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject6mark` int(11) DEFAULT NULL,
	`subject7name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject7mark` int(11) DEFAULT NULL,
	`subject8name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject8mark` int(11) DEFAULT NULL,
	`subject9name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject9mark` int(11) DEFAULT NULL,
	`subject10name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`subject10mark` int(11) DEFAULT NULL,
	`aggregate` int(11) DEFAULT NULL,
	`division` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`updatingflags` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`updatingclass` int(11) DEFAULT NULL,
	`updatestatus` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

CREATE TABLE `daris`.`users` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
	`password` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`role` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=latin1,
	COLLATE=latin1_swedish_ci,
	ENGINE=InnoDB;

INSERT INTO `daris`.`users` (
  `id`, `username`, `email`, `password`, `role`, `created`, `modified`
)
VALUES (
  '1','rogerokello',
  'rogerokello@gmail.com','$2a$10$KE21qtubTzVfOTIJCJJWwubGlemtxClCxGxBpMbx6D6BAkYFdavzC',
  'admin','',''
);

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 1, 0, 's';

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 2, 0, 's';

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 3, 0, 's';

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 4, 0, 's';

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 5, 0, 's';

INSERT INTO `daris`.`registrationnumbers` (
  `yearused`, `classused`, `lastnumberused`, `classlevel`
)
SELECT YEAR(CURDATE()), 6, 0, 's';

INSERT INTO `daris`.`schoolstreams` (
  `stream`, `shortstreamname`
)
VALUES (
  'WHITE', 'W'
);

INSERT INTO `gradeprofiles` (`id`, `profilename`) VALUES
(41, 'Lower Ordinary level (S1 and S2)'),
(42, 'Upper Ordinary-level (S3 and S4)'),
(43, 'Advanced Level (S5 and S6)');

INSERT INTO `advancedlevelpointsawards` (`id`, `gradeprofile_id`, `lowestvalue`, `highestvalue`, `award`, `weight`) VALUES
(341, 41, NULL, NULL, '', NULL),
(342, 41, NULL, NULL, '', NULL),
(343, 41, NULL, NULL, '', NULL),
(344, 41, NULL, NULL, '', NULL),
(345, 41, NULL, NULL, '', NULL),
(346, 41, NULL, NULL, '', NULL),
(347, 42, NULL, NULL, '', NULL),
(348, 42, NULL, NULL, '', NULL),
(349, 42, NULL, NULL, '', NULL),
(350, 42, NULL, NULL, '', NULL),
(351, 42, NULL, NULL, '', NULL),
(352, 42, NULL, NULL, '', NULL),
(353, 43, '1.00', '2.00', 'A', 6),
(354, 43, '2.01', '3.00', 'B', 5),
(355, 43, '3.01', '4.00', 'C', 4),
(356, 43, '4.01', '5.00', 'D', 3),
(357, 43, '5.01', '6.00', 'E', 2),
(358, 43, '6.01', '7.00', 'O', 1),
(359, 43, '7.01', '9.00', 'F', 0),
(360, 41, NULL, NULL, '', NULL),
(361, 42, NULL, NULL, '', NULL);

INSERT INTO `advancedlevelpointsawardsettings` (`id`, `gradeprofile_id`, `captoOforF9inanypaper`) VALUES
(67, 41, 0),
(68, 42, 0),
(69, 43, 1);

INSERT INTO `gradeprofileusesettings` (`id`, `gradeprofile_id`, `criterea`) VALUES
(56, 41, 'ordinarylevel'),
(57, 42, 'ordinarylevel'),
(58, 43, 'advancedlevel');

INSERT INTO `gradings` (`id`, `gradeprofile_id`, `lowestvalue`, `highestvalue`, `award`, `remarks`) VALUES
(536, 41, 80, 101, '1', 'Excellent'),
(537, 41, 70, 80, '2', 'Very Good'),
(538, 41, 65, 70, '3', 'Good'),
(539, 41, 60, 65, '4', 'Good'),
(540, 41, 55, 60, '5', 'Fairly Good'),
(541, 41, 50, 55, '6', 'Fairly Good'),
(542, 41, 45, 50, '7', 'Improve'),
(543, 41, 35, 45, '8', 'Work Harder'),
(544, 41, 0, 35, '9', 'Work Harder'),
(545, 42, 80, 101, '1', 'Excellent'),
(546, 42, 70, 80, '2', 'Very Good'),
(547, 42, 65, 70, '3', 'Good'),
(548, 42, 60, 65, '4', 'Good'),
(549, 42, 55, 60, '5', 'Fairly Good'),
(550, 42, 50, 55, '6', 'Fairly Good'),
(551, 42, 45, 50, '7', 'Improve'),
(552, 42, 35, 45, '8', 'Work Harder'),
(553, 42, 0, 35, '9', 'Work Harder'),
(554, 43, 80, 101, '1', NULL),
(555, 43, 70, 80, '2', NULL),
(556, 43, 65, 70, '3', NULL),
(557, 43, 60, 65, '4', NULL),
(558, 43, 55, 60, '5', NULL),
(559, 43, 50, 55, '6', NULL),
(560, 43, 45, 50, '7', NULL),
(561, 43, 35, 45, '8', NULL),
(562, 43, 0, 35, '9', NULL);

INSERT INTO `ordinaryleveldivisionawards` (`id`, `gradeprofile_id`, `lowestvalue`, `highestvalue`, `award`) VALUES
(234, 41, 8, 32, 'I'),
(235, 41, 32, 45, 'II'),
(236, 41, 46, 58, 'III'),
(237, 41, 59, 71, 'IV'),
(238, 42, 8, 32, 'I'),
(239, 42, 33, 45, 'II'),
(240, 42, 46, 58, 'III'),
(241, 42, 59, 71, 'IV'),
(242, 43, NULL, NULL, ''),
(243, 43, NULL, NULL, ''),
(244, 43, NULL, NULL, ''),
(245, 43, NULL, NULL, '');

INSERT INTO `ordinaryleveldivisionawardsettings` (`id`, `gradeprofile_id`, `getbestsubjects`, `nobestsubjectstoget`, `captodiv2forpassineng`, `captodiv2forF9inmaths`, `captodiv3forF9inenglish`, `shifttodiv7forlessthanbestnumberofsubjects`, `gradeusingtotalmark`) VALUES
(71, 41, 1, 8, 1, 1, 1, 1, 1),
(72, 42, 1, 8, 1, 1, 1, 1, 0),
(73, 43, 0, NULL, 0, 0, 0, 0, 0);

INSERT INTO `profileassignments` (`id`, `class`, `gradeprofile_id`) VALUES
(13, 1, 41),
(14, 2, 41),
(15, 3, 42),
(16, 4, 42),
(17, 5, 43),
(18, 6, 43);

INSERT INTO `schooldoneexams` (`id`, `fullexamname`, `alias`, `startdate`, `enddate`, `termdone`) VALUES
(15, 'MID TERM ONE', 'MID-T I', NULL, NULL, 'ONE'),
(16, 'END OF TERM ONE', 'EOT I', NULL, NULL, 'ONE'),
(17, 'MID TERM TWO', 'MID-T II', NULL, NULL, 'TWO'),
(18, 'END OF TERM TWO', 'EOT II', NULL, NULL, 'TWO'),
(19, 'MID TERM THREE', 'MID-T III', NULL, NULL, 'THREE'),
(20, 'END OF TERM THREE', 'EOT III', NULL, NULL, 'THREE');

INSERT INTO `schooldonesubjects` (`id`, `fullsubjectname`, `shortsubjectname`, `subjectcode`, `subjectgroup`) VALUES
(47, 'English Language', 'ENG', '112', 'I'),
(48, 'Computer Studies', 'CST', '840', 'VIII'),
(49, 'Commerce', 'COMM', '800', 'VIII'),
(50, 'Literature in English', 'LIT', '208', 'II'),
(51, 'Christian Religious Education', 'CRE', '223', 'II'),
(52, 'History', 'HIST', '241', 'II'),
(53, 'Geography', 'GEOG', '273', 'II'),
(54, 'Mathematics', 'MTH', '456', 'IV'),
(55, 'Agriculture: Principles and Practice', 'AGRIC', '527', 'V'),
(56, 'Physics', 'PHY', '535', 'V'),
(57, 'Chemistry', 'CHEM', '545', 'V'),
(58, 'Biology', 'BIO', '553', 'V'),
(59, 'ART', 'ART', '610', 'VI'),
(60, 'Entrepreneurship skills', 'ENT', '845', 'VIII');