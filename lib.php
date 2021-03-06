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
 * Library of interface functions and constants for module webrtcexperiments
 *
 * All the core Moodle functions, neeeded to allow the module to work
 * integrated in Moodle should be placed here.
 * All the webrtcexperiments specific functions, needed to implement all the module
 * logic, should go to locallib.php. This will help to save some memory when
 * Moodle is performing actions across all modules.
 *
 * @package    mod_webrtcexperiments
 * @copyright  2014 Daniel Neis Araujo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Moodle core API
 */

/**
 * Returns the information on whether the module supports a feature
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function webrtcexperiments_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the webrtcexperiments into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $webrtc An object from the form in mod_form.php
 * @param mod_webrtcexperiments_mod_form $mform
 * @return int The id of the newly inserted webrtcexperiments record
 */
function webrtcexperiments_add_instance(stdClass $webrtc, mod_webrtcexperiments_mod_form $mform = null) {
    global $DB;

    $webrtc->timecreated = time();

    return $DB->insert_record('webrtcexperiments', $webrtc);
}

/**
 * Updates an instance of the webrtcexperiments in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $webrtc An object from the form in mod_form.php
 * @param mod_webrtcexperiments_mod_form $mform
 * @return boolean Success/Fail
 */
function webrtcexperiments_update_instance(stdClass $webrtc, mod_webrtcexperiments_mod_form $mform = null) {
    global $DB;

    $webrtc->timemodified = time();
    $webrtc->id = $webrtc->instance;

    return $DB->update_record('webrtcexperiments', $webrtc);
}

/**
 * Removes an instance of the webrtcexperiments from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function webrtcexperiments_delete_instance($id) {
    global $DB;

    if (! $webrtc = $DB->get_record('webrtcexperiments', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('webrtcexperiments', array('id' => $webrtc->id));

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return stdClass|null
 */
function webrtcexperiments_user_outline($course, $user, $mod, $webrtc) {

    $return = new stdClass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @param stdClass $course the current course record
 * @param stdClass $user the record of the user we are generating report for
 * @param cm_info $mod course module info
 * @param stdClass $webrtc the module instance record
 * @return void, is supposed to echp directly
 */
function webrtcexperiments_user_complete($course, $user, $mod, $webrtc) {
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in webrtcexperiments activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 */
function webrtcexperiments_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  // True if anything was printed, otherwise false.
}

/**
 * Prepares the recent activity data
 *
 * This callback function is supposed to populate the passed array with
 * custom activity records. These records are then rendered into HTML via
 * {@link webrtcexperiments_print_recent_mod_activity()}.
 *
 * @param array $activities sequentially indexed array of objects with the 'cmid' property
 * @param int $index the index in the $activities to use for the next record
 * @param int $timestart append activity since this time
 * @param int $courseid the id of the course we produce the report for
 * @param int $cmid course module id
 * @param int $userid check for a particular user's activity only, defaults to 0 (all users)
 * @param int $groupid check for a particular group's activity only, defaults to 0 (all groups)
 * @return void adds items into $activities and increases $index
 */
function webrtcexperiments_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
}

/**
 * Prints single activity item prepared by {@see webrtcexperiments_get_recent_mod_activity()}
 *
 * @return void
 */
function webrtcexperiments_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function webrtcexperiments_cron () {
    return true;
}

/**
 * Returns all other caps used in the module
 *
 * @example return array('moodle/site:accessallgroups');
 * @return array
 */
function webrtcexperiments_get_extra_capabilities() {
    return array();
}

/**
 * Gradebook API                                                              //
 */

/**
 * Is a given scale used by the instance of webrtc?
 *
 * This function returns if a scale is being used by one webrtc
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $webrtcid ID of an instance of this module
 * @return bool true if the scale is used by the given webrtc instance
 */
function webrtcexperiments_scale_used($webrtcid, $scaleid) {
    return false;
}

/**
 * Checks if scale is being used by any instance of webrtc.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param $scaleid int
 * @return boolean true if the scale is used by any webrtc instance
 */
function webrtcexperiments_scale_used_anywhere($scaleid) {
    return false;
}

/**
 * Creates or updates grade item for the give webrtc instance
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $webrtc instance object with extra cmidnumber and modname property
 * @param mixed optional array/object of grade(s); 'reset' means reset grades in gradebook
 * @return void
 */
function webrtcexperiments_grade_item_update(stdClass $webrtc, $grades=null) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    $item = array();
    $item['itemname'] = clean_param($webrtc->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;
    $item['grademax']  = $webrtc->grade;
    $item['grademin']  = 0;

    grade_update('mod/webrtcexperiments', $webrtc->course, 'mod', 'webrtcexperiments', $webrtc->id, 0, null, $item);
}

/**
 * Update webrtc grades in the gradebook
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $webrtc instance object with extra cmidnumber and modname property
 * @param int $userid update grade of specific user only, 0 means all participants
 * @return void
 */
function webrtcexperiments_update_grades(stdClass $webrtc, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    $grades = array(); // Populate array of grade objects indexed by userid.

    grade_update('mod/webrtcexperiments', $webrtc->course, 'mod', 'webrtcexperiments', $webrtc->id, 0, $grades);
}

/**
 * File API                                                                   //
 */

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function webrtcexperiments_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * File browsing support for webrtc file areas
 *
 * @package mod_webrtc
 * @category files
 *
 * @param file_browser $browser
 * @param array $areas
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param int $itemid
 * @param string $filepath
 * @param string $filename
 * @return file_info instance or null if not found
 */
function webrtcexperiments_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    return null;
}

/**
 * Serves the files from the webrtc file areas
 *
 * @package mod_webrtc
 * @category files
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param stdClass $context the webrtc's context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 */
function webrtcexperiments_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload, array $options=array()) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}

/**
 * Navigation API                                                             //
 */

/**
 * Extends the global navigation tree by adding webrtc nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the webrtc module instance
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function webrtcexperiments_extend_navigation(navigation_node $navref, stdclass $course, stdclass $module, cm_info $cm) {
}

/**
 * Extends the settings navigation with the webrtc settings
 *
 * This function is called when the context for the page is a webrtc module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@link settings_navigation}
 * @param navigation_node $webrtcnode {@link navigation_node}
 */
function webrtcexperiments_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $webrtcnode=null) {
}
