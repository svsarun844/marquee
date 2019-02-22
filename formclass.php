<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
 
class simplehtml_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG, $DB;
        $updateId = optional_param('updateId', 0, PARAM_INT);
        
        $getmarqueeUpdate = $DB->get_record_sql("SELECT * FROM mdl_custom_marquee WHERE id = $updateId");
	//echo '<pre>';print_r($getmarqueeUpdate);
	$getCourseSql = $DB->get_records_sql("SELECT id, fullname FROM mdl_course WHERE visible = 1 AND id != 1");
	$coursedata = array(1 => 'Show', 0 => "Hide");
	//foreach($getCourseSql as $getcourse) {
	//$coursedata[$getcourse->id] = $getcourse->fullname;
	//}
	$description = $getmarqueeUpdate->description;
	$description_format = $getmarqueeUpdate->descriptionformat;


	//array_unshift($coursedata, 'Please Select');
        $mform = $this->_form; // Don't forget the underscore! 
        
        
       // $mform->addRule('status', 'Please Select Course', 'required', null, 'client');
        

        
        $mform->addElement('textarea', 'description', 'Description', 'rows="10" cols="20" maxlength="200"');        
        $mform->addRule('description', 'Missing Description', 'required', null, 'client');       
	$mform->setDefault('description', $description);	        

        $mform->setDefault('status', $getmarqueeUpdate->status);
	$select = $mform->addElement('select', 'status', 'Status', $coursedata);

       // $mform->addElement('date_time_selector', 'timestart', get_string('from'));
        
        //$mform->setDefault('timestart', $getmarqueeUpdate->starttime);
        
        //$mform->addElement('date_time_selector', 'timeend', get_string('to'));
        
       // $mform->setDefault('timeend', $getmarqueeUpdate->endtime);
     
	//$descriptionfields = 'description';
        
        /*$mform->hardFreeze( $descriptionfields);*/
		
	$mform->addElement('hidden', 'updateId', $getmarqueeUpdate->id);
		
	$mform->addElement('hidden', 'description_update', $description);
        
        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
