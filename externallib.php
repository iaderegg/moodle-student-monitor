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
    public function get_course_categories_parameters()
    {
        return new external_function_parameters(
            array(
                'parent' => new external_value(PARAM_INT, 'ID of the parent category')
            )
        );
    }
    
    /**
     * Get course categories
     *
     * @param  int $parent
     * @return array with course categories JSON and warnings
     */
    public function get_course_categories($parent)
    {
        $courseCategoriesArray = array();

        $courseCategoriesManager = new manager_course_categories;
        $courseCategoriesArray = $courseCategoriesManager->get_course_categories($parent);

        return array(
            'course_categories' => json_encode($courseCategoriesArray),
            'warnings' => []
        );
    }
    
    /**
     * Returns the description of the external function get course categories return value.
     *
     * @return external_description
     * @since Moodle 3.9
     */
    public function get_course_categories_returns()
    {
        return new external_single_structure(array(
            'course_categories' => new external_value(PARAM_RAW, 'JSON for course categories'),
            'warnings' => new external_warnings()
        ));
    }
}
