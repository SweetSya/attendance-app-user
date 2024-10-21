<?php // Code within app\Helpers\Helper.php

if (! function_exists('API_storage')) {
    function API_storage($url, $private = false)
    {
        if ($private) {
            return env('APP_API_HOST') . '/private-storage/' . $url;
        } else {
            return env('APP_API_HOST') . '/storage/' . $url;
        }
    }
}

if (! function_exists('employee_status')) {
    function employee_status($status)
    {
        switch ($status) {
            case 'active':
                return 'Aktif';
            case 'vacation':
                return 'Cuti';
            case 'unactive':
                return 'Nonaktif';
        }
    }
}

