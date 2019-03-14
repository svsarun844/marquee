<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * marquee block caps.
 *
 * @package    block_marquee
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_marquee extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_marquee');
    }

    function get_content() {
        global $DB,$CFG,$PAGE;
	    $PAGE->requires->css( new moodle_url($CFG->wwwroot . '/blocks/marquee/styles.css'));
		require_once($CFG->dirroot.'/config.php');
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';        
		if(is_siteadmin()) {	       
 $this->content->text .= '<br><p><a href="'.$CFG->wwwroot.'/blocks/marquee/list.php"><strong>Click here</strong></a> to manage Innovate News</p><br>';
		}
		
	$marquee = $DB->get_records('custom_marquee', array('status' => 1), '', '*'); 
	
	$i=0; 
	foreach($marquee as $news){ 
	$i++;
	$variable .= $news->description."&nbsp;&nbsp;";
	
	if($i != count($marquee)) 
	$variable .= "|";
	$variable .= "&nbsp;&nbsp";
	}	
	$this->content->text .= '<p class="microsoft marquee"><b>'.$variable.'</b></p>';	
       
        return $this->content;
    }
}
