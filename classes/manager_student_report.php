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
 * Manager student report
 *
 * @package   report_studentmonitor
 * @copyright 2021 Iader E. García Gómez <iader.garcia@correounivalle.edu.co>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace report_studentmonitor;
use \stdClass;

require_once($CFG->dirroot . '/enrol/externallib.php');
require_once($CFG->dirroot . '/grade/report/user/externallib.php');
require_once($CFG->dirroot . '/lib/enrollib.php');

class manager_student_report {

    public function __construct() {

    }
    
    /**
     * Get all courses of an user
     *
     * @param  int $userId
     * @return array courses
     */
    public function get_courses_user($userId){

        $courses = enrol_get_all_users_courses($userId);

        return array_values($courses);

    }
    
    /**
     * Get a student's course grades
     *
     * @param  mixed $userId
     * @param  mixed $courseId
     * @return array student grades
     */
    public function get_grades_course_by_student($courseId, $userId){

        $studentGradesTable = \gradereport_user_external::get_grades_table($courseId, $userId);
        $studentGradesData = $studentGradesTable['tables'][0];

        $studentGrades = array();

        $studentItems = array();
        $studentItems['userid'] = $studentGradesData['userid'];
        $studentItems['items'] = array();

        foreach($studentGradesData['tabledata'] as $keyStudent => $item){
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

        return $studentGrades;
    }
}


