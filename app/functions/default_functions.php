<?php

/**
 * Var dump the variable and die the script.
 *
 * @param mixed ...$expression The expression to debug.
 *
 * @return void
 */
function dd(...$expression)
{
    foreach ($expression as $item) {
        echo "<pre>";
        var_dump($item);
    }

    die();
}

if (!function_exists('array_key_last')) {
    /**
     * Polyfill for array_key_last() function added in PHP 7.3.
     *
     * Get the last key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array An array
     *
     * @return int|string|null The last key of array if the array is not empty; NULL otherwise.
     */
    function array_key_last(array $array)
    {
        end($array);
        $key = key($array);

        return $key;
    }
}

/**
 * Load a file and return it.
 *
 * @param string $filename The filename.
 * @param null   $vars     The vars to use in the loaded file file.
 *
 * @return resource
 */
function loadFile(string $filename, $vars = null)
{
    if (!empty($vars)) {
        extract($vars);
    }
    \App\services\core\Validate::var($filename)->fileExists();

    return include $filename;
}

/**
 * Load a picture and return it.
 *
 * @param string $name     The filename.
 * @param string $fallback The fallback for the filename.
 *
 * @return string the image or a fallback otherwise nothing.
 */
function loadImage(string $name, string $fallback)
{
    if (!empty($name) && file_exists($_SERVER['DOCUMENT_ROOT'] . $name)) {
        return $name;
    }

    if (!empty($fallback) && file_exists($_SERVER['DOCUMENT_ROOT'] . $fallback)) {
        return $fallback;
    }

    return '';
}

/**
 * Load a table and return it.
 *
 * @param string $filename The filename.
 * @param array  $keys     The keys to use in the loaded table.
 * @param array  $rows     The rows to use in the loaded table.
 *
 * @return resource
 */
function loadTable(string $filename, array $keys, array $rows = [])
{
    $filename = RESOURCES_PATH . "/partials/tables/{$filename}.view.php";
    \App\services\core\Validate::var($filename)->fileExists();

    return include_once $filename;
}

/**
 * This function replaces the keys of an associate array by those supplied in the keys array
 *
 * @param array $array target associative array in which the keys are intended to be replaced
 * @param array $keys  associate array where search key => replace by key, for replacing respective keys
 *
 * @return array with replaced keys
 */
function array_replace_keys(array $array, array $keys)
{
    foreach ($keys as $search => $replace) {
        if (isset($array[$search])) {
            $array[$replace] = $array[$search];
            unset($array[$search]);
        }
    }

    return $array;
}

/**
 * Parse the data into HTML entities.
 *
 * @param string $data The data to be parsed.
 *
 * @return string
 */
function parseHTMLEntities($data)
{
    return html_entity_decode(htmlspecialchars_decode($data));
}

/**
 * Check if the given date is a correct type.
 *
 * @param string $date   The date to be checked.
 * @param string $format The format of the date.
 *
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}

/**
 * Parse the given datetime into readable html.
 *
 * @param string $datetime The data to be parsed.
 *
 * @return string
 */
function parseToDate($datetime)
{
    $fmt = new IntlDateFormatter(
        'nl_NL',
        IntlDateFormatter::FULL,
        IntlDateFormatter::NONE
    );

    return $fmt->format(strtotime($datetime));
}

/**
 * Parse the given datetime into readable html.
 *
 * @param string $datetime The data to be parsed.
 *
 * @return string
 */
function parseToTime($datetime)
{
    $fmt = new IntlDateFormatter(
        'nl_NL',
        IntlDateFormatter::NONE,
        IntlDateFormatter::SHORT
    );

    return $fmt->format(strtotime($datetime));
}

/**
 * Parse the given datetime into input html.
 *
 * @param string $datetime The data to be parsed.
 *
 * @return string
 */
function parseToInput($datetime)
{
    $newDatetime = strtotime($datetime);
    $newDatetime = strftime('%d-%m-%Y %T', $newDatetime);

    return $newDatetime;
}

/**
 * Parse the given datetime into date input html.
 *
 * @param string $datetime The data to be parsed.
 *
 * @return string
 */
function parseToDateInput($datetime)
{
    $newDatetime = strtotime($datetime);
    $newDatetime = strftime('%d-%m-%Y', $newDatetime);

    return $newDatetime;
}

/**
 * Parse the given datetime into input html.
 *
 * @param string $datetime The data to be parsed.
 *
 * @return string
 */
function parseToTimeInput($datetime)
{
    $newDatetime = strtotime($datetime);
    $newDatetime = strftime('%R', $newDatetime);

    return $newDatetime;
}

function arrayToCSV($inputArray)
{
    $csvFieldRow = array();
    foreach ($inputArray as $CSBRow) {
        $csvFieldRow[] = str_putcsv($CSBRow);
    }
    $csvData = implode("\n", $csvFieldRow);
    return $csvData;
}

function str_putcsv($input, $delimiter = ',', $enclosure = '"')
{
    // Open a memory "file" for read/write
    $fp = fopen('php://temp', 'r+');
    // Write the array to the target file using fputcsv()
    fputcsv($fp, $input, $delimiter, $enclosure);
    // Rewind the file
    rewind($fp);
    // File Read
    $data = fread($fp, 1048576);
    fclose($fp);
    // Ad line break and return the data
    return rtrim($data, "\n");
}

/**
 * Takes in a filename and an array associative data array and outputs a csv file
 *
 * @param string $fileName
 * @param array  $assocDataArray
 */
function outputCsv($fileName, $assocDataArray)
{
    ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $fileName . '.csv');

    if (!empty($assocDataArray) && is_array($assocDataArray)) {
        $fp = fopen('php://output', 'w');
        foreach ($assocDataArray as $values) {
            fputcsv($fp, $values);
        }
        fclose($fp);
    }
    ob_flush();
}
