<?php

use App\Models\AccDate;
use App\Models\Cash;
use App\Models\Cash_Writing;
use App\Models\Priv_Menu;
use App\Models\ValWriting;
use App\Models\Writing;
use Illuminate\Support\Facades\Session;

if (!function_exists('verifySession')) {
    /**
     * @param $key
     */
    function verifSession($key)
    {
        if (Session::has($key)) {
            $session = Session::get($key);
            return $session;
        }
        return null;
    }
}

if (!function_exists('verifPriv')) {
    /**
     * @param int $level
     * @param int $menu
     * @param int $privilege
     * @return bolean
     */
    function verifPriv(int $level, int $menu, int $privilege): bool
    {
        $result = true;

        switch ($level) {
            case 1:
                $priv = Priv_Menu::getVerifPrivMenu("menu_1", $menu, $privilege);
                if ($priv === null) {
                    $result = false;
                }
                break;
            case 2:
                $priv = Priv_Menu::getVerifPrivMenu("menu_2", $menu, $privilege);
                if ($priv === null) {
                    $result = false;
                }
                break;
            case 3:
                $priv = Priv_Menu::getVerifPrivMenu("menu_3", $menu, $privilege);
                if ($priv === null) {
                    $result = false;
                }
                break;
            case 4:
                $priv = Priv_Menu::getVerifPrivMenu("menu_4", $menu, $privilege);
                if ($priv === null) {
                    $result = false;
                }
                break;
            default:
                return false;
                break;
        
        }

        return $result;
    }
}

if (!function_exists('trimOver')) {
    /**
     * @param string $subject
     * @param $search
     * @return string
     * Used to remove blank spaces
     */
    function trimOver(string $subject = null, $search = null): string
    {
        if($subject !== null) {
            if ($search !== null) {
                return str_replace($search, '', $subject);
            }
            return str_replace(['(', ')'], '', $subject);
        }
        return 0;
    }
}

if (!function_exists('changeFormat')) {
    /**
     * @param string $date
     * @return string
     */
    function changeFormat(string $date): string
    {
        //return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
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

if (!function_exists('getsDateTime')) {
    /**
     * @param string $date
     * @return false|string
     */
    function getsDateTime(string $date)
    {
        return date('d/m/Y H:i:s', strtotime($date));
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

if (!function_exists('dbDate')) {
    /**
     * @param string $date
     * @return false|string
     */
    function dbDate(string $date = null)
    {
        if ($date !== null) {
            return date('Y/m/d', strtotime($date));
        }
        return null;
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
    //                $convert = numfmt_create('fr', NumberFormatter::SPELLOUT);
                $convert = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
            } else {
    //                $convert = numfmt_create('en', NumberFormatter::SPELLOUT);
                $convert = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            }
            return strtoupper($convert->format($number));
    //            return strtoupper(numfmt_format($convert, $number));
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

if (!function_exists('compareCash')) {
    /**
     * @param array $numbers_1
     * @param array $numbers_2
     * @return bool
     */
    function compareCash(array $numbers_1, array $numbers_2)
    {
        $error = true;

        foreach ($numbers_1 as $key => $number_1) {
            if ((int)$number_1 > 0 && (int)$numbers_2[$key] > 0) {
                if ($number_1 < $numbers_2[$key]) {
                    $error = false;
                }
            }
        }
        return $error;
    }
}

if (!function_exists('cashOpen')) {
    /**
     * @param int|null $employee
     * @return bool
     */
    function cashOpen(int $employee = null)
    {
        if ($employee !== null) {
            return Cash::getEmpCashOpen($employee) !== null;
        }
        return Cash::getEmpCashOpen() !== null;
    }
}

if (!function_exists('cashEmpty')) {
    /**
     * @param int|null $employee
     * @return mixed
     */
    function cashEmpty(int $employee = null)
    {
        $emp = Session::get('employee');
        $cash = null;

        if ($employee === null) {
            $cash = Cash::getEmpCash($emp->iduser);
        } else {
            $cash = Cash::getEmpCash($employee);
        }
        return Cash::getSumBillet($cash->idcash)->total;
    }
}

if (!function_exists('cashReOpen')) {
    /**
     * @return bool
     */
    function cashReOpen()
    {
        return Cash::getEmpCashReopen() === null;
    }
}

if (!function_exists('dateOpen')) {
    /**
     * @return bool
     */
    function dateOpen(int $branch = null)
    {
        if ($branch !== null) {
            return AccDate::getOpenAccDate($branch) !== null;
        }
        return AccDate::getOpenAccDate() !== null;
    }
}

if (!function_exists('getWritNumb')) {
    /**
     * @return int|mixed
     */
    function getWritNumb(int $branch = null)
    {
        $writnumb = 1;
        $writing = null;
        $valwriting = null;

        if ($branch === null) {
            $writing = Writing::getLast();
            $valwriting = ValWriting::getLast();
        } else {
            $writing = Writing::getLast($branch);
            $valwriting = ValWriting::getLast($branch);
        }

        if ($writing !== null && $valwriting === null) {
            $writnumb += $writing->writnumb;
        }
        if ($writing === null && $valwriting !== null) {
            $writnumb += $valwriting->writnumb;
        }
        if ($writing !== null && $valwriting !== null) {
            $writnumb += $writing->writnumb;
        }


        return $writnumb;
    }
}

if (!function_exists('getCashWritNumb')) {
    /**
     * @return int|mixed
     */
    function getCashWritNumb()
    {
        $writnumb = 1;
        $writing = Cash_Writing::getLast();
        if ($writing !== null) {
            $writnumb += $writing->writnumb;
        }

        return $writnumb;
    }
}

if (!function_exists('formSeries')) {
    /**
     * @param int $numb
     * @param int|null $branch
     * @return string
     */
    function formSeries(int $numb, int $branch = null)
    {
        if ($branch === null) {
            $emp = Session::get('employee');
            $branch = $emp->branch;
        }

        return formDate() . '' . pad($branch) . '' . pad($numb, 6);
    }
}

if (!function_exists('formWriting')) {
    /**
     * @param string $date
     * @param int $network
     * @param int $zone
     * @param int $institution
     * @param int $branch
     * @param int $numb
     * @return string
     */
    function formWriting(string $date = null, int $network, int $zone, int $institution, int $branch, int $numb)
    {
        if ($date === null) {
            return formDate() . '' . pad($network) . '' . pad($zone) . '' . pad($institution) . '' . pad($branch) . '' . pad($numb, 6);
        }
        return formDate($date) . '' . pad($network) . '' . pad($zone) . '' . pad($institution) . '' . pad($branch) . '' . pad($numb, 6);
    }
}

if (!function_exists('backupDB')) {

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $name
     * @param bool $backup_name
     * @param int|null $network
     * @param int|null $institution
     * @param bool $tables
     */
    function backupDB(string $host, string $user, string $pass, string $name, $backup_name = false, int $network = null, int $institution = null, $tables = false)
    {
        set_time_limit(3000);

        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES');

        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }

        if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }

        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";

        $errors = [];

        foreach ($target_tables as $table) {
            if (empty($table)) {
                continue;
            }

            $result = $mysqli->query('SELECT * FROM `' . $table . '` WHERE institution = ' . $institution . ' AND network = '. $network);
        //            $result	= $mysqli->query('SELECT * FROM `'.$table.'`');

            if ($result === false) {
                $errors = [$table];
            } else {
                $fields_amount = $result->field_count;
                $rows_num = $mysqli->affected_rows;

                $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
                $TableMLine = $res->fetch_row();
                $content .= "\n\n" . $TableMLine[1] . ";\n\n";
                $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
                for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                    while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                        if ($st_counter % 100 == 0 || $st_counter == 0) {
                            $content .= "\nINSERT INTO " . $table . " VALUES";
                        }
                        $content .= "\n(";
                        for ($j = 0; $j < $fields_amount; $j++) {
                            $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                            if (isset($row[$j])) {
                                $content .= '"' . $row[$j] . '"';
                            } else {
                                $content .= '""';
                            }
                            if ($j < ($fields_amount - 1)) {
                                $content .= ',';
                            }
                        }
                        $content .= ")";
                        //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                        if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                            $content .= ";";
                        } else {
                            $content .= ",";
                        }
                        $st_counter = $st_counter + 1;
                    }
                }
                $content .= "\n\n\n";
            }
        }

        if (!empty($errors)) {
            dd($errors);
        }

        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        $backup_name = $backup_name ? $backup_name : $name . '___(' . date('H-i-s') . '_' . date('d-m-Y') . ').sql';
        ob_get_clean();
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $content;
        exit;
    }
}

if (!function_exists('restoreDB')) {

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $dbname
     * @param $sql_file_OR_content
     * @return string
     */
    function restoreDB(string $host, string $user, string $pass, string $dbname, $sql_file_OR_content)
    {
        set_time_limit(3000);
        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content));
        $allLines = explode("\n", $SQL_CONTENT);
        $mysqli = new mysqli($host, $user, $pass, $dbname);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $zzzzzz = $mysqli->query('SET foreign_key_checks = 0');
        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
        foreach ($target_tables[2] as $table) {
            $mysqli->query('DROP TABLE IF EXISTS ' . $table);
        }
        $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');
        $mysqli->query("SET NAMES 'utf8'");
        $templine = '';    // Temporary variable, used to store current query
        foreach ($allLines as $line) {                                            // Loop through each line
            if (substr($line, 0, 2) != '--' && $line != '') {
                $templine .= $line;    // (if it is not a comment..) Add this line to the current segment
                if (substr(trim($line), -1, 1) == ';') {        // If it has a semicolon at the end, it's the end of the query
                    if (!$mysqli->query($templine)) {
                        print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');
                    }
                    $templine = ''; // set variable to empty, to start picking up the lines after ";"
                }
            }
        }
        return 'Importing finished. Now, Delete the import file.';
    }
}
