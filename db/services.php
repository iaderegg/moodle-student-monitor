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
 * Web services for report Student Monitor
 * @package   report_studentmonitor
 * @subpackage db
 * @since Moodle 3.9
 * @copyright  2021 Iader E. Garcia G. <iadergg@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$functions = array(
    'report_studentmonitor_get_course_categories' => array(
        'classname'          => 'report_studentmonitor_external',
        'methodname'         => 'get_data_table_course_categories',
        'description'        => 'Get course categories from the Moodle site.',
        'requiredcapability' => '',
        'type'               => 'read',
        'ajax'               => true,
        'restrictedusers'    => 0,
        'enabled'            => 1,
        'downloadfiles'      => 0,
        'uploadfiles'        => 0
    ),
    'report_studentmonitor_get_courses_by_category' => array(
        'classname'          => 'report_studentmonitor_external',
        'methodname'         => 'get_courses_by_category',
        'description'        => 'Get courses by a course category from the Moodle site.',
        'requiredcapability' => '',
        'type'               => 'read',
        'ajax'               => true,
        'restrictedusers'    => 0,
        'enabled'            => 1,
        'downloadfiles'      => 0,
        'uploadfiles'        => 0
    ),
    'report_studentmonitor_get_student_course_grades' => array(
        'classname'          => 'report_studentmonitor_external',
        'methodname'         => 'get_student_course_grades',
        'description'        => 'Get students course grades.',
        'requiredcapability' => '',
        'type'               => 'read',
        'ajax'               => true,
        'restrictedusers'    => 0,
        'enabled'            => 1,
        'downloadfiles'      => 0,
        'uploadfiles'        => 0
    )
);