<?php
require_once('../../config.php');
	
//include formclass.php
require_once($CFG->dirroot.'/blocks/marquee/formclass.php');
 
global $DB,$COURSE,$PAGE,$OUTPUT;
$PAGE->set_pagelayout('incourse');
$PAGE->set_title('Scroll News: Update');
$PAGE->set_heading('Scroll News');

require_login();

if(!is_siteadmin()) 
{
	redirect($CFG->wwwroot.'/my/','You do not have permission.');
}

	echo $OUTPUT->header();
	//echo '<p style="float: right;"><a href="'.$CFG->wwwroot.'/blocks/marquee/list.php"><strong>Back to scroll news</strong></a></p>';
 	echo '<h3>Edit Scroll News</h3>';
//Instantiate simplehtml_form 
$mform = new simplehtml_form();
 
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot.'/blocks/marquee/list.php');
} else if ($fromform = $mform->get_data()) {
	//echo '<pre>';print_r($fromform);die;
	/*
        $updateId = $fromform->updateId;
	$courseid = $fromform->course;
	$timestart = $fromform->timestart;
	$timeend = $fromform->timeend;
	$venue = addslashes($fromform->venue);
	$description = addslashes($fromform->description['text']);
	$descriptionformat = $fromform->description['format'];
	$DB->execute("UPDATE mdl_custom_marquee SET courseid = $courseid, starttime = $timestart, endtime = $timeend, venue = '$venue', description = '$description', descriptionformat = $descriptionformat WHERE id = $updateId");
	redirect($CFG->wwwroot.'/blocks/marquee/list.php','Updated Successfully');
*/

$record1 = new stdClass();
$record1->id  = $fromform->updateId;
$record1->description = $fromform->description;
$record1->status = $fromform->status;
//$record1->created = time();
$updated = $DB->update_record('custom_marquee', $record1);
redirect($CFG->wwwroot.'/blocks/marquee/list.php','Updated Successfully');

} else {
	$mform->display();
}

    echo $OUTPUT->footer();
?>
<script>
$(document).ready(function() {
	var descriptionUpdate = $('input[name="description_update"]').val();
	$("#id_description").val(descriptionUpdate);
});
</script>
