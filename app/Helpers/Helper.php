<?php

use App\Models\AccDate;
use App\Models\Cash;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\Session;

if (!function_exists('trimOver')) {
    /**
     * @param string $subject
     * @param $search
     * @return string
     */
    function trimOver(string $subject, $search = null): string
    {
        if ($search !== null) {
            return str_replace($search, '', $subject);
        }
        return str_replace(['(', ')'], '', $subject);
    }
}

if (!function_exists('changeFormat')) {
    /**
     * @param string $date
     * @return string
     */
    function changeFormat(string $date): string
    {
        return date('d/m/Y', strtotime($date));
    }
}

if (!function_exists('getsDate')) {
    /**
     * @param string $date
     * @return false|string
     */
    function getsDate(string $date)
    {
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('getsTime')) {
    /**
     * @param string $date
     * @return false|string
     */
    function getsTime(string $date)
    {
        return date('H:i:s', strtotime($date));
    }
}

if (!function_exists('formDate')) {
    /**
     * @param string $date
     * @return false|string
     */
    function formDate(string $date = null)
    {
        if ($date === null) {
            return date('ymd');
        }
        return date('ymd', strtotime($date));
    }
}

if (!function_exists('pad')) {
    /**
     * @param $number
     * @param int $size
     * @param string $type
     * @return string
     */
    function pad($number, int $size = 2, $type = 'left')
    {
        if ($type !== 'left') {
            return str_pad($number, $size, 0, STR_PAD_RIGHT);
        }
        return str_pad($number, $size, 0, STR_PAD_LEFT);
    }
}

if (!function_exists('substrWords')) {
    /**
     * @param string $text
     * @param int $size
     * @return string
     */
    function substrWords(string $text, int $size = 2)
    {
        $length = strlen($text);
        if ($length < $size) {
            $output = $text;
            for ($i = 0; $i < ($size - $length); $i++) {
                $output .= '0';
            }
            return $output;
        }
        return substr($text, 0, $size);
    }
}

if (!function_exists('money')) {
    /**
     * @param $number
     * @param string $decimals
     * @param string $dec_point
     * @param string $thousands_point
     * @return string
     */
    function money($number, $decimals = '', $dec_point = ' ', $thousands_point = ' ')
    {
        if ($decimals !== null) {
            $len = count(explode('.', (string)$number));
            $decimals = $len > 1 ? $len : 0;
        }

        if ($dec_point === null) {
            $dec_point = '.';
        }

        if ($thousands_point === null) {
            $thousands_point = ',';
        }

        $number = number_format($number, $decimals);

        $number = str_replace(',', $dec_point, $number);

        $splitNum = explode($dec_point, $number);
        $splitNum[0] = str_replace('/\B(?=(\d{3})+(?!\d))/g', $thousands_point, $splitNum[0]);
        $number = implode($dec_point, $splitNum);

        return $number;
    }
}

if (!function_exists('digitToWord')) {
    /**
     * @param $number
     * @return string|null
     */
    function digitToWord($number)
    {
        $emp = Session::get('employee');

        if ($number !== 0) {
            $convert = '';
            if ($emp->lang === 'fr') {
                $convert = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
            } else {
                $convert = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            }
            return strtoupper($convert->format($number));
        }
        return null;
    }
}

if (!function_exists('totCash')) {
    /**
     * @param array $numbers
     * @return int|mixed
     */
    function totCash(array $numbers)
    {
        $total = 0;

        foreach ($numbers as $number) {
            $total += $number;
        }
        return $total;
    }
}

if (!function_exists('cashOpen')) {
    /**
     * @return bool
     */
    function cashOpen()
    {
        if (Cash::getEmpCashOpen() !== null) {
            return true;
        }
        return false;
    }
}

if (!function_exists('cashReOpen')) {
    /**
     * @return bool
     */
    function cashReOpen()
    {
        if (Cash::getEmpCashReopen() === null) {
            return true;
        }
        return false;
    }
}

if (!function_exists('dateOpen')) {
    /**
     * @return bool
     */
    function dateOpen()
    {
        if (AccDate::getOpenAccDate() !== null) {
            return true;
        }
        return false;
    }
}

if (!function_exists('getWritNumb')) {
    /**
     * @return int|mixed
     */
    function getWritNumb()
    {
        $writnumb = 1;
        $writing = Writing::getLast();
        $valwriting = ValWriting::getLast();
        if ($writing !== null && $valwriting === null) {
            $writnumb += $writing->writnumb;
        }
        if ($writing === null && $valwriting !== null) {
            $writnumb += $valwriting->writnumb;
        }

        return $writnumb;
    }
}
