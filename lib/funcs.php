<?php

require_once "lib/db_settings.php";

$PAGES = array(
    'home',
    'programme',
    'committees',
    'registration',
    'participants',
    'accommodation',
    'transportation',
    'about_the_location',
    'proceedings',

/*
  'program',
  'conference_information',
  'registration',
  'speaker_information',
  'accommodation',
  'travel_information',
*/
);

$NOT_IMPLEMENTED_PAGES = array(
    'proceedings',
    'participants',
);

$HIDDEN_PAGES = array(
    'msgs',
    'user',
);

/* everything that is printet from db to html should go though this function for security */
function P($var) { return htmlentities($var); }

/* Shorthand to print a bool from the database ("1" -> TRUE, otherwise false) */
function B($var) { return $var==="1"? "yes":"no"; }


function print_menu($active_page)
{
    global $PAGES, $NOT_IMPLEMENTED_PAGES;

    foreach ($PAGES as $page_) {
        $page = str_replace('_', ' ', $page_);

        $cls = array();

        if ($page_ == $active_page) {
            array_push($cls, 'active');
            $page = '&#x25B8; '.$page;
        }

        if (in_array($page_, $NOT_IMPLEMENTED_PAGES)) {
            array_push($cls, 'not_implemented');
        }

        $classes = '';
        if (!empty($cls)) {
            $classes = " class='".implode(',', $cls)."'";
        }

        echo "    <li$classes><a href='?page=$page_'>$page</a></li>\n";
    }
}

/**
 * Convert a comma separated file into an associated array.
 * The first row should contain the array keys.
 *
 * Example:
 *
 * @param string $filename  Path to the CSV file
 * @param string $delimiter The separator used in the file
 *
 * @return array
 *
 * @link http://gist.github.com/385876
 *
 * @author Jay Williams <http://myd3.com/>
 * @copyright Copyright (c) 2010, Jay Williams
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
function csv_to_array($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename)) {
        return false;
    }

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header) {
                $header = $row;
            } else {
                $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }

    return $data;
};
