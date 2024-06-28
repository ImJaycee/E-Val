<?php

if (!function_exists('getCurrentSemester')) {
    function getCurrentSemester() {
        $currentMonth = date('m');

        if ($currentMonth >= 8 && $currentMonth <= 12) {
            return '1st';
        } elseif ($currentMonth >= 2 && $currentMonth <= 6) {
            return '2nd';
        } else {
            return 'semestral break'; // January is enrollment period, so no current semester
        }
    }
}

if (!function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear() {
        $currentMonth = date('m');
        $currentYear = date('Y');


        if ($currentMonth >= 2 && $currentMonth <= 6) {
            // If the current month is between February and June, it's the second semester of the academic year
            return ($currentYear - 1) . '-' . $currentYear;
        } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
            // If the current month is between August and December, it's the first semester of the academic year
            return $currentYear . '-' . ($currentYear + 1);
        } else {
            // For January and July, we assume the academic year spans two years
            // January is considered part of the second semester's academic year
            if ($currentMonth == 1 || $currentMonth == 7) {
                return ($currentYear - 1) . '-' . $currentYear;
            }
        }
    }
}

