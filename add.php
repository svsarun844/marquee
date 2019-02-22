<?php
require_once('../../config.php');
	
//include formclass.php
require_once($CFG->dirroot.'/blocks/marquee/formclass.php');
 
global $DB,$COURSE,$PAGE,$OUTPUT;
$PAGE->set_pagelayout('incourse');
$PAGE->set_title('Scroll News: Add');
$PAGE->set_heading('Scroll News');

if(isset($_GET['deleteId'])) {
	$delId = $_GET['deleteId'];
	$delQry = "DELETE FROM mdl_marquee WHERE id = $delId";
	$execQry = $DB->execute($delQry);
	redirect($CFG->wwwroot."/blocks/marquee/list.php?id=$courseid","Deleted Successfully");
}

require_login();

if(!is_siteadmin()) {
	redirect($CFG->wwwroot.'/my/','You do not have permission.');
}

	echo $OUTPUT->header();
	//echo '<p style="float: right;"><a href="'.$CFG->wwwroot.'/blocks/marquee/list.php"><strong>View marquee</strong></a></p>';
 	echo '<h3>New Scroll News</h3>';
	$mform = new simplehtml_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot.'/blocks/marquee/list.php');
} else if ($fromform = $mform->get_data()) {


//echo '<pre>';print_r($fromform);die;

	/* 
        $courseid = $fromform->course;
	$timestart = $fromform->timestart;
	$timeend = $fromform->timeend;
	$venue = addslashes($fromform->venue);
	$description = addslashes($fromform->description['text']);
	$descriptionformat = $fromform->description['format'];
	$created = time();
       
	$DB->execute("INSERT INTO mdl_custom_marquee (courseid, starttime, endtime, venue, description, descriptionformat, created) VALUES ($courseid, $timestart, $timeend, '$venue', '$description', $descriptionformat, $created)");
*/

$record1 = new stdClass();
$record1->description = $fromform->description; 
$record1->status = $fromform->status;
$record1->created = time();
$lastinsertid = $DB->insert_record('custom_marquee', $record1);

if($lastinsertid){
         redirect($CFG->wwwroot.'/blocks/marquee/list.php','Added Successfully');
}

} else {
	$mform->display();
}
    echo $OUTPUT->footer();
?>
