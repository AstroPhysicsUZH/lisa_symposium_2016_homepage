<?php

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

function print_news()
{
    $news = csv_to_array('data/news.csv');

    // sort by date, newest on top
    function compare_date($a, $b)
    {
      return strnatcmp($b['date'], $a['date']);
    }
    usort($news, 'compare_date');

    echo "<ul>\n";
    foreach ($news as $v) {
        $strdate = $v['date'];
        echo "<li><span class='date'>$strdate</span> {$v['comment']}</li>\n";
    }
    echo "</ul>\n";
}

function print_hotels()
{
    $hotels = csv_to_array('data/hotels.csv');

    foreach ($hotels as $hotel) {
        #var_dump($hotel);

    $shorttel = str_replace(' ', '', $hotel['tel']);
        $img = (isset($hotel['img']) && $hotel['img']) ? $hotel['img'] : 'generic_hotel.jpg';

        echo <<<EOL
<div class='hotel'>
  <a class='imga' href="img/hotels/$img">
  <img src="img/hotels/_$img" />
  </a>
  <h3>{$hotel['name']}</h3>

  <div class="address">
  {$hotel['street']}<br>
  {$hotel['loc']}
  </div>

  <a class="web" href="{$hotel['url']}">{$hotel['url']}</a>
  <a class="mail" href="mailto:{$hotel['email']}">contact</a>
  <a class="tel" href="tel:$shorttel">{$hotel['tel']}</a>
</div>
EOL;
    }
}

function print_sac()
{
    $news = csv_to_array('data/science_advisory_committee.csv');

  // sort by date, newest on top
  function compare_lastname($a, $b)
  {
      return strnatcmp($a['last_name'], $b['last_name']);
  }
    usort($news, 'compare_lastname');

    echo "<ul>\n";
    foreach ($news as $v) {
        echo "  <li>{$v['first_name']} {$v['last_name']}</li>\n";
    }
    echo "</ul>\n";
}

function get_programme_json()
{
    echo "var evtSrcsBrks = { events: [\n";

    for ($i = 5; $i < 9; ++$i) {
        echo <<<EOT

// Enter recurring breaks here
  { start:'2016-09-0{$i}T10:30:00', end:'2016-09-0{$i}T11:00:00', title:'Break' },
  { start:'2016-09-0{$i}T13:00:00', end:'2016-09-0{$i}T14:00:00', title:'Lunch Break' },
  { start:'2016-09-0{$i}T15:30:00', end:'2016-09-0{$i}T16:00:00', title:'Break' },

EOT;
    };

    echo <<<EOT

// Enter singular break events here
  { start:'2016-09-07T18:00:00', end:'2016-09-07T23:00:00', title:'Apero and Conference Dinner' },

  { start:'2016-09-09T10:30:00', end:'2016-09-09T11:00:00', title:'Break' },
  { start:'2016-09-09T13:00:00', end:'2016-09-09T14:00:00', title:'Lunch Break' },

EOT;

    echo "  ], color: '#ff8888', textColor: 'black'};\n\n";

    echo <<<EOT
  var evtSrcsCTalks = { events: [

// Enter Plenary Talks

// MO
  { start:'2016-09-05T09:00:00', end:'2016-09-05T09:30:00', title:'Opening' },
  { start:'2016-09-05T09:30:00', end:'2016-09-05T13:00:00', title:'Talks' },
// Di
  { start:'2016-09-06T09:00:00', end:'2016-09-06T13:00:00', title:'Talks' },

// Mi
  { start:'2016-09-07T09:00:00', end:'2016-09-07T13:00:00', title:'Talks' },
  { start:'2016-09-07T14:00:00', end:'2016-09-07T17:00:00', title:'Joint eLISA and L3ST consortium meeting' },

// Do
  { start:'2016-09-08T09:00:00', end:'2016-09-08T13:00:00', title:'Talks' },

// Fr
  { start:'2016-09-09T09:00:00', end:'2016-09-09T13:00:00', title:'Talks' },

// \------
  ], color:'#88ff88', textColor:'black', borderColor:'#008800' };

EOT;

    echo <<<EOT
  var evtSrcsPTalks = { events: [

// Enter Parallelsessions
  { start:'2016-09-05T14:00:00', end:'2016-09-05T17:00:00', title:'Parallel Talks' },
  { start:'2016-09-05T14:30:00', end:'2016-09-05T17:30:00', title:'Parallel Talks' },

  { start:'2016-09-06T14:00:00', end:'2016-09-06T17:00:00', title:'Parallel Talks' },
  { start:'2016-09-06T14:30:00', end:'2016-09-06T17:30:00', title:'Parallel Talks' },

  { start:'2016-09-08T14:00:00', end:'2016-09-08T17:00:00', title:'Parallel Talks' },
  { start:'2016-09-08T14:30:00', end:'2016-09-08T17:30:00', title:'Parallel Talks' },

  ], color:'#ffff88', textColor:'black', borderColor:'#aaaa00' };

EOT;
}