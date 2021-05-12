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
 * Manager course categories
 *
 * @package   report_studentmonitor
 * @copyright 2021 Iader E. García Gómez <iader.garcia@correounivalle.edu.co>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_studentmonitor;
use \stdClass;

class manager_course_categories {

    public function __construct() {

    }
    
    /**
     * Get course categories
     *
     * @param  int $idParent
     * @return array Object array with course categories
     */
    public function get_course_categories( $idParent ){

        global $DB;

        $table = "course_categories";
        $select = "parent = ".$idParent." AND id <> 1";

        $courseCategories = $DB->get_records_select($table, $select, null, 'id');

        return array_values($courseCategories);
    }
    
    /**
     * get_courses_by_category
     *
     * @return void
     */
    public function get_courses_by_category($idCategory){

        global $DB;

        $table = "course";
        $select = "category = ".$idCategory." AND visible = 1";

        $courses = $DB->get_records_select($table, $select, null, 'fullname');

        return array_values($courses);
        
    }
}
