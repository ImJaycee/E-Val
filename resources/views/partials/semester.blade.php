<?php

if (!function_exists('getCurrentSemester')) {
    function getCurrentSemester() {
        $currentMonth = date('m');

        if ($currentMonth >= 8 && $currentMonth <= 12) {
            return '1st';
        } elseif ($currentMonth >= 2 && $currentMonth <= 6) {
            return '2nd';
        } else {
            return null;
        }
    }
}

if (!function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear() {
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 2 && $currentMonth <= 6) {
            // If the current month is between January and May, it's the second part of the academic year
            return ($currentYear - 1) . '-' . $currentYear;
        } else {
            // Otherwise, it's the first part of the academic year
            return $currentYear . '-' . ($currentYear + 1);
        }
    }
}
