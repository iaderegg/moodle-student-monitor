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
 * Manager list of participants
 *
 * @package   report_studentmonitor
 * @copyright 2021 Iader E. García Gómez <iader.garcia@correounivalle.edu.co>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace report_studentmonitor;
use \stdClass;

require_once($CFG->dirroot . '/enrol/externallib.php');
require_once($CFG->dirroot . '/grade/report/user/externallib.php');
require_once($CFG->dirroot . '/course/lib.php');

class manager_list_participants {

    public function __construct() {

    }
    
    /**
     * Get list of course participants.
     *
     * @param  int $courseId
     * @return array course participants
     */
    public function get_list_participants($courseId){

        $courseParticipants = array();
        $columnsData = array();

        $coursecontext = \context_course::instance($courseId);
        $selectParameters = "u.id, u.username, u.firstname, u.lastname, u.email";
        $professors = array_values(get_enrolled_users($coursecontext, 'moodle/course:manageactivities', 0, $selectParameters, 'u.username ASC'));
        $students = array_values(get_enrolled_users($coursecontext, 'mod/assignment:submit', 0, $selectParameters, 'u.username ASC'));

        $studentsGrades = array_values(self::get_grades_student_list($courseId));
        
        foreach ($students as $key => &$student) {

            $counterItems = 0;

            foreach($studentsGrades as $studentGrades){
                if($studentGrades['userid'] == $student->id){
                    $items = $studentGrades['items'];
                }
            }

            foreach ($items as $keyItem => $item){

                if($key == 0){
                    $columName = array();
                    $columName['itemid'] = "item".$counterItems;
                    $columName['columname'] = $item['itemname'];
                    array_push($columnsData, $columName);
                }                
                
                $identifier = "item".$counterItems;
                $student->$identifier = $item['grade'];
                $counterItems += 1;
            }
        }

        $courseParticipants['professors'] = $professors;
        $courseParticipants['students'] = $students;
        $courseParticipants['columns'] = $columnsData;
        
        return $courseParticipants;
    }
    
    /**
     * Get basic course data
     *
     * @param  int $courseId
     * @return array data course
     */
    public function get_course_data($courseId){

        global $DB;

        $course = $DB->get_record("course", array("id"=>$courseId), "fullname, shortname, startdate, enddate");

        $coursecontext = \context_course::instance($courseId);
        $selectParameters = "u.username, u.firstname, u.lastname, u.email";
        $counterStudents = count(get_enrolled_users($coursecontext, 'mod/assignment:submit', 0, $selectParameters, 'u.username ASC'));

        $course->counter_students = $counterStudents;

        if($course->startdate <= 0){
            $course->start_date = get_string("studentmonitor:course_no_startdate", "report_studentmonitor");
        }else{
            $course->start_date = date("d-m-Y", $course->startdate);
        }

        if($course->enddate <= 0){
            $course->end_date = get_string("studentmonitor:course_no_enddate", "report_studentmonitor");
        }else{
            $course->end_date = date("DD MM YYYY", $course->enddate);
        }

        return (array)$course;

    }
    
    /**
     * Get student grades
     *
     * @param  int $courseId
     * @return array
     */
    public function get_grades_student_list($courseId){
        
        $studentGradesTable = \gradereport_user_external::get_grades_table($courseId);

        $studentGrades = array();

        foreach ($studentGradesTable['tables'] as $key => $student) {

            $studentItems = array();
            $studentItems['userid'] = $student['userid'];
            $studentItems['items'] = array();

            foreach($student['tabledata'] as $keyStudent => $item){
                $studentItem = array();

                if(!array_key_exists('leader', $item)){
                    $studentItem['itemname'] = $item['itemname']['content'];
                    $studentItem['weight'] = $item['weight']['content'];
                    $studentItem['grade'] = $item['grade']['content'];
                    $studentItem['range'] = $item['range']['content'];
                    $studentItem['percentage'] = $item['percentage']['content'];
                    $studentItem['feedback'] = $item['feedback']['content'];
                    $studentItem['contributiontocoursetotal'] = $item['contributiontocoursetotal']['content'];

                    array_push($studentItems['items'], $studentItem);
                }               
            }
            
            array_push($studentGrades, $studentItems);
        }

        return $studentGrades;
    }
}