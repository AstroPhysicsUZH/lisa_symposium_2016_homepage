<?php

$PAGES = array(
  'overview',
  'program',
  'accomodation',
  'travel',
  'registration'
);

$IMPLEMENTED_PAGES = array(
  'overview',
  'accomodation',
  );




function print_menu($active_page) {

  global $PAGES, $IMPLEMENTED_PAGES;

  foreach ($PAGES as $page) {

    $cls = array();

    if ($page == $active_page) {
      array_push($cls, "active");
    }

    if ( ! in_array($page, $IMPLEMENTED_PAGES)) {
      array_push($cls, "not_implemented");
    }

    $classes = "";
    if (!empty($cls)) {
      $classes = " class='" . implode(",", $cls) . "'";
    }

    print "    <li$classes><a href='?page=$page'>$page</a></li>\n";
  }

}


function get_hotel_array() {
  return array_map('str_getcsv', file('hotels.csv'));
  
}


/**
 * Convert a comma separated file into an associated array.
 * The first row should contain the array keys.
 * 
 * Example:
 * 
 * @param string $filename Path to the CSV file
 * @param string $delimiter The separator used in the file
 * @return array
 * @link http://gist.github.com/385876
 * @author Jay Williams <http://myd3.com/>
 * @copyright Copyright (c) 2010, Jay Williams
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
function csv_to_array($filename='', $delimiter=',')
{
  if(!file_exists($filename) || !is_readable($filename))
    return FALSE;
  
  $header = NULL;
  $data = array();
  if (($handle = fopen($filename, 'r')) !== FALSE)
  {
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
    {
      if(!$header)
        $header = $row;
      else
        $data[] = array_combine($header, $row);
    }
    fclose($handle);
  }
  return $data;
}