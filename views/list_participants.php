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
 * The listing participant page.
 *
 * @package   report_studentmonitor
 * @copyright  2021 Iader E. Garcia G. <iadergg@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../../config.php';

require_once($CFG->libdir.'/adminlib.php');

require_login();

$courseId = required_param('id', PARAM_INT); // Course ID.

$managerListParticipants = new report_studentmonitor\manager_list_participants();
$courseParticipants = $managerListParticipants->get_list_participants($courseId);

$data = new stdClass();
$data->professors = $courseParticipants['professors'];
$data->students = $courseParticipants['students'];

if(count($data->professors) > 0){
    $data->hasProfessors = 1;
}

if(count($data->students) > 0){
    $data->hasStudents = 1;
}

$url = new moodle_url('/report/studentmonitor/list_participants.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_title(get_string("title", "report_studentmonitor"));
$PAGE->set_heading(get_string("studentmonitor:head_list_participants", "report_studentmonitor"));

$PAGE->requires->css('/report/studentmonitor/styles/list_participants.css', true);
$PAGE->requires->css('/report/studentmonitor/styles/datatables.min.css', true);
$PAGE->requires->css('/report/studentmonitor/styles/dataTables.bootstrap4.min.css', true);
$PAGE->requires->css('/report/studentmonitor/styles/buttons.bootstrap4.min.css', true);
$PAGE->requires->css('/report/studentmonitor/styles/sweetalert.css', true);

$PAGE->requires->js_call_amd('report_studentmonitor/listParticipants', 'init');

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('report_studentmonitor/list_participants', $data);

echo $OUTPUT->footer();

die;