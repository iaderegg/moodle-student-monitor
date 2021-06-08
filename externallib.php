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
 * External lib for report Student Monitor
 * @package   report_studentmonitor
 * @since Moodle 3.9
 * @copyright  2021 Iader E. Garcia G. <iadergg@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/externallib.php");

use report_studentmonitor\manager_course_categories;
use report_studentmonitor\manager_student_report;

/**
 * Report Student Monitor functions
 * @copyright 2021 Iader E. Garcia Gómez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_studentmonitor_external extends external_api
{

    /**
     * Returns the description of the external function parameters.
     * 
     * @return external_function_parameters
     * @since Moodle 3.9
     */
    public function get_data_table_course_categories_parameters()
    {
        return new external_function_parameters(
            array(
                'categoryCourseId' => new external_value(PARAM_INT, 'ID of the parent category')
            )
        );
    }
    
    /**
     * Get course categories
     *
     * @param  int $parent
     * @return array with course categories JSON and warnings
     */
    public function get_data_table_course_categories($categoryCourseId)
    {
        global $CFG; 

        $courseCategoriesArray = array();
        $coursesToReturn = array();

        $courseCategoriesManager = new manager_course_categories;
        $courseCategoriesArray = $courseCategoriesManager->get_course_categories($categoryCourseId);
        $courses = $courseCategoriesManager->get_courses_by_category($categoryCourseId);

        foreach($courses as $key => $course){

            $courseToReturn = new stdClass();

            $courseOptions = "<a href='".$CFG->wwwroot."/course/view.php?id=".$course->id."' target='_blank'>";
            $courseOptions .= "<span class='fa fa-eye icon-options-course' ";
            $courseOptions .= "title='".get_string("studentmonitor:title_icon_view_course", "report_studentmonitor")."' id='icon-view-'";
            $courseOptions .= s($course->id)."></span>";
            $courseOptions .= "</a>";

            $courseOptions .= "<a href='".$CFG->wwwroot."/report/studentmonitor/list_participants.php?id=".$course->id."' target='_blank'>";
            $courseOptions .= "<span class='fa fa-list icon-options-course'";
            $courseOptions .= "title='".get_string("studentmonitor:title_icon_list_participants", "report_studentmonitor")."' id='icon-list-'";
            $courseOptions .= s($course->id)."></span>";
            $courseOptions .= "</a>";

            $courseToReturn->fullname = $course->fullname;
            $courseToReturn->students = $course->students;
            $courseToReturn->professors = $course->professors;
            $courseToReturn->options = $courseOptions;

            array_push($coursesToReturn, $courseToReturn);

        }

        return array(
            'course_categories' => json_encode($courseCategoriesArray),
            'courses' => json_encode($coursesToReturn),
            'warnings' => []
        );
    }
    
    /**
     * Returns the description of the external function get course categories return value.
     *
     * @return external_description
     * @since Moodle 3.9
     */
    public function get_data_table_course_categories_returns()
    {
        return new external_single_structure(array(
            'course_categories' => new external_value(PARAM_RAW, 'JSON for course categories.'),
            'courses' => new external_value(PARAM_RAW, 'JSON for courses in a category.'),
            'warnings' => new external_warnings()
        ));
    }
    
    /**
     * Returns the description of the external function parameters.
     * 
     * @return external_function_parameters
     * @since Moodle 3.9
     */
    public function get_student_course_grades_parameters(){

        return new external_function_parameters(
            array(
                'courseId' => new external_value(PARAM_INT, 'ID of the course'),
                'userId' => new external_value(PARAM_INT, 'ID of the user')
            )
        );        
    }

    /**
     * Get student's course grades
     *
     * @param  mixed $courseId
     * @param  mixed $userId
     * @return array with student's course grades
     */
    public function get_student_course_grades($courseId, $userId){

        $studentReportManager = new manager_student_report;
        $studentGrades = $studentReportManager->get_grades_course_by_student($courseId, $userId);

        return array(
            'grades' => json_encode($studentGrades),
            'warnings' => []
        );

    }

    /**
     * Returns the description of the external function get student's course grades return value.
     *
     * @return external_description
     * @since Moodle 3.9
     */
    public function get_student_course_grades_returns(){
        return new external_single_structure(array(
            'grades' => new external_value(PARAM_RAW, 'JSON for course categories.'),
            'warnings' => new external_warnings()
        ));
    }
}
