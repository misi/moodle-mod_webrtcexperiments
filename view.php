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
 * Prints a particular instance of webrtc
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_webrtc
 * @copyright  2014 Daniel Neis Araujo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// (Replace webrtc with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // webrtc instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('webrtc', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $webrtc  = $DB->get_record('webrtc', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $webrtc  = $DB->get_record('webrtc', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $webrtc->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('webrtc', $webrtc->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

add_to_log($course->id, 'webrtc', 'view', "view.php?id={$cm->id}", $webrtc->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/webrtc/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($webrtc->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

$PAGE->requires->js('/mod/webrtc/meeting.js');

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('webrtc-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($webrtc->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('webrtc', $webrtc, $cm->id), 'generalbox mod_introbox', 'webrtcintro');
}

// Replace the following lines with you own code
echo '<article>
            <section class="experiment">
                <section>
                    <input type="text" id="meeting-name">
                    <button id="setup-meeting">Setup New Meeting</button>
                </section>

                <table style="width: 100%;" id="meetings-list"></table>
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <h2 style="display: block; font-size: 1em; text-align: center;">You!</h2>
							<div id="local-streams-container"></div>
                        </td>
                        <td style="background: white;">
                            <h2 style="display: block; font-size: 1em; text-align: center;">Remote Peers</h2>
							<div id="remote-streams-container"></div>
                        </td>
                    </tr>
                </table>
            </section>';

$PAGE->requires->js_init_call('M.mod_webrtc.init_meeting', array($webrtc->signalingserver));

// Finish the page
echo $OUTPUT->footer();