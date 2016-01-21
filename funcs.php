<?php

$PAGES = array(
  'home',
  'about_the_conference',
  'about_the_location',
  'info_for_participants',
  'info_for_presenters',
  'travel_information',
  'registration',
  'programme'
  
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
  'program',
  'registration',
  );




function print_menu($active_page) {

  global $PAGES, $NOT_IMPLEMENTED_PAGES;

  foreach ($PAGES as $page_) {
    
    $page = str_replace('_', ' ', $page_);

    $cls = array();

    if ($page_ == $active_page) {
      array_push($cls, "active");
      $page = "&#x25B8; ".$page;
    }

    if ( in_array($page_, $NOT_IMPLEMENTED_PAGES) ) {
      array_push($cls, "not_implemented");
    }

    $classes = "";
    if (!empty($cls)) {
      $classes = " class='" . implode(",", $cls) . "'";
    }

    print "    <li$classes><a href='?page=$page_'>$page</a></li>\n";
  }

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


function print_news() {
  $news = csv_to_array('news.csv');
  
  // sort by date, newest on top
  function compare_date($a, $b) { return strnatcmp($b['date'], $a['date']);}
  usort($news, 'compare_date');

  echo "<ul>\n";
  foreach ($news as $v) {
    $strdate = $v['date'];
    echo "<li><span class='date'>$strdate</span> {$v['comment']}</li>\n";
  }
  echo "</ul>\n";
}


function print_hotels() {

  $hotels = csv_to_array('hotels.csv');
  
  foreach ($hotels as $hotel) {
    #var_dump($hotel);
    
    $shorttel = str_replace(' ', '', $hotel["tel"]);
    $img = (isset($hotel["img"]) && $hotel["img"]) ? $hotel["img"] : 'generic_hotel.jpg';

    echo <<<EOL
<div class='hotel'>
  <a class='imga' href="img/hotels/$img">
  <img src="img/hotels/_$img" />
  </a>
  <h3>{$hotel["name"]}</h3>

  <div class="address">
  {$hotel["street"]}<br>
  {$hotel["loc"]}
  </div>

  <a class="web" href="{$hotel["url"]}">{$hotel["url"]}</a>
  <a class="mail" href="mailto:{$hotel["email"]}">contact</a>
  <a class="tel" href="tel:$shorttel">{$hotel["tel"]}</a>
</div>
EOL;
  }
}




