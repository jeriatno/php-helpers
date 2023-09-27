<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

if (!function_exists('formatCurrency')) {
    function formatCurrency($price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($price): string
    {
        return number_format($price, 0, ',', '.');
    }
}

if (!function_exists('parseDateRange')) {
    function parseDateRange($dateRange)
    {
        // Separate the start date and end date using '-' as a separator
        $dateParts = explode(' - ', $dateRange);

        if (count($dateParts) !== 2) {
            return null;
        }

        // Split the start date and end date into year, month, and day
        $start = date_parse_from_format('m/d/Y', $dateParts[0]);
        $end = date_parse_from_format('m/d/Y', $dateParts[1]);

        if ($start === false || $end === false) {
            return null;
        }

        $year = $start['year'];
        $month = $start['month'];
        $start_period = $year . '-' . $month . '-' . $start['day'];
        $end_period = $year . '-' . $month . '-' . $end['day'];

        return [
            'year' => $year,
            'month' => $month,
            'start_period' => $start_period,
            'end_period' => $end_period,
        ];
    }
}

if (!function_exists('getMonthName')) {
    function getMonthName($month, $locale = 'id_ID')
    {
        $month = intval($month);

        if ($month < 1 || $month > 12) {
            return 'Invalid month';
        }

        $monthName = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $monthName[$month];
    }
}

if (!function_exists('pathLast')) {
    function pathLast()
    {
        $path = array_slice(explode('/', URL::current()), -1, 1);

        return $path[0];
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return Carbon::parse($date)->timezone('Asia/Makassar');
    }
}

if (!function_exists('formatCounted')) {
    function formatCounted($number)
    {
        $angka = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
            'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'
        ];

        if ($number < 20) {
            return $angka[$number];
        } elseif ($number < 100) {
            return $angka[floor($number / 10)] . ' Puluh ' . formatCounted($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . formatCounted($number - 100);
        } elseif ($number < 1000) {
            return $angka[floor($number / 100)] . ' Ratus ' . formatCounted($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . formatCounted($number - 1000);
        } elseif ($number < 1000000) {
            return formatCounted(floor($number / 1000)) . ' Ribu ' . formatCounted($number % 1000);
        } elseif ($number < 1000000000) {
            return formatCounted(floor($number / 1000000)) . ' Juta ' . formatCounted($number % 1000000);
        } elseif ($number < 1000000000000) {
            return formatCounted(floor($number / 1000000000)) . ' Milyar ' . formatCounted($number % 1000000000);
        } else {
            return 'Data terlalu besar!';
        }
    }
}
