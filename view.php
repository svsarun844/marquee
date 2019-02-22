<?php
require_once('../../config.php');
 
global $DB,$COURSE,$PAGE,$OUTPUT;
$PAGE->set_pagelayout('incourse');
$PAGE->set_title('Schedule: View');
$PAGE->set_heading('Schedule');

$viewId = optional_param('viewid', 0, PARAM_INT);
	echo $OUTPUT->header();
	echo '<p style="float: right;"><a href="'.$CFG->wwwroot.'/blocks/schedules/list.php"><strong>View Schedules</strong></a></p>';
 	echo '<h3>View Schedule</h3>';
	$getSingleView = $DB->get_record('custom_schedules', array('id'=>$viewId));
        $curCourId = $getSingleView->courseid;
?>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}
td:first-child {
	font-weight: bold;
}
</style>
<table>
	<tr>
	<td>Course</td>
	<td>
	<?php
		$getSingleCourse = $DB->get_record('course', array('id'=>$getSingleView->courseid)); 
		echo $getSingleCourse->fullname;
	?>
	</td>
	</tr>
	<tr>
	<td>No. of Places</td>
	<td>
	<?php
		$getMaxSeats = $DB->get_record('enrol',array('courseid' => $getSingleView->courseid, 'enrol' => 'hsbcglobal'));
		if($getMaxSeats) { 
			if($getMaxSeats->maxuser == 0) { 
				echo 'Unlimited'; 
			} else { 
				echo $getMaxSeats->maxuser; 
			} 
		} else { echo '0'; }
	?>
	</td>
	</tr>
        <tr>
	<td>No. of Vacancies</td>
	<td>
	<?php
           $instance_id = $DB->get_record('enrol',array('courseid' => $curCourId, 'enrol' => 'hsbcglobal'));
           $vac_qry = "SELECT  count(*) as cnt FROM mdl_enrol_hsbcglobal as eh LEFT JOIN mdl_user_enrolments as ue ON eh.instanceid = ue.enrolid where eh.instanceid = '".$instance_id->id."' AND eh.reason_code!='D' AND  eh.userid = ue.userid";
      //  $vac_qry = "SELECT count(*) as cnt FROM mdl_user_enrolments where enrolid = '".$instance->id."'";
        $vacancies_arr = $DB->get_record_sql($vac_qry);
        $vacancies = $vacancies_arr->cnt;

           //  $vacancies = $DB->count_records('enrol_hsbcglobal' , array('courseid' => $curCourId, 'instanceid' => $instance_id->id));
                           
                            
                               if($getMaxSeats->maxuser>0  ){ 
                                  if($vacancies> $getMaxSeats->maxuser) 
                                      echo $getMaxSeats->maxuser;
                                  else
                                      echo $getMaxSeats->maxuser - $vacancies ; 
                              }
                              else { 
                              echo "Unlimited"; 

                              }
	?>
	</td>
	</tr>
 
	<tr>
	<td>Start Date</td>
	<td>
		<?php echo date("F d, Y", $getSingleView->starttime); ?>
	</td>
	</tr>
	<tr>
	<td>End Date</td>
	<td>
		<?php echo date("F d, Y", $getSingleView->endtime); ?>
	</td>
	</tr>
	<tr>
	<td>Venue</td>
	<td>
		<?php echo stripslashes($getSingleView->venue); ?>
	</td>
	</tr>
	<tr>
	<td>Description</td>
	<td>
		<?php echo stripslashes($getSingleView->description); ?>
	</td>
	</tr>
</table>

<?php

    echo $OUTPUT->footer();
?>
