
<p>
  We recommend the following hotels.<br>
  For more choice consult <a href="https://www.zuerich.com/en/visit/accommodation-hotel-bed-and-breakfast-hostel"> the webpage of Zurich tourism</a>.
  <br>
  To profit from the reservations and the special prices printed below, please use the keyword <b>LISA Conference 2016</b> while booking.
  If two rates are given, then the first is the weekend price, the second for during the week. (Prices should include city tax).
  The number in brackets after the room type show the total of available rooms. (Not the number of free rooms!)
</p>

<p class="warning">
  Please make sure to book <b>way in advance</b>.<br>
  September is a crowded time in Zurich and Hotels are likely to book out very early.
</p>


<?php

$hotels = csv_to_array('data/hotels.csv');

foreach ($hotels as $hotel) {
    #var_dump($hotel);
    if (!$hotel['show']=="Y") {continue;}

    $shorttel = str_replace(' ', '', $hotel['tel']);
    $img = (isset($hotel['img']) && $hotel['img']) ? $hotel['img'] : 'generic_hotel.jpg';

    echo "<div class='hotel'>\n";
    echo "  <a class='imga' href='img/hotels/$img'>\n";
    echo "    <img src='img/hotels/_$img' />\n";

    if ($hotel['aircon'] === 'Y') {
        echo "    <img title='has air conditioning' class='ico x1' src='img/aircon.png' />\n";
    }
    if ($hotel['wifi'] === 'Y') {
        echo "    <img title='has free wifi' class='ico x2' src='img/wifi.png' />\n";
    }
    if ($hotel['breakfast'] === 'Y') {
        echo "    <img title='breakfast included' class='ico x3' src='img/breakfast.png' />\n";
    }
    echo "  </a>\n";
    echo "  <h3>{$hotel['name']}</h3>\n";
    echo "  <div class='address'>\n";
    if (isset($hotel['street'])) { echo "    {$hotel['street']}<br>\n"; }
    if (isset($hotel['loc']))    { echo "    {$hotel['loc']}\n"; }
    echo "  </div>\n";

    echo isset($a) ? "" : "" ;

    if (isset($hotel['url']))  { echo "  <a class='web' href='{$hotel['url']}'>{$hotel['url']}</a>\n"; }
    if (isset($hotel['mail'])) { echo "  <a class='mail' href='mailto:{$hotel['email']}'>{$hotel['email']}</a>\n"; }
    if (isset($hotel['tel']))  { echo "  <a class='tel' href='tel:$shorttel'>{$hotel['tel']}</a>\n"; }

    if (isset($hotel['name1']) && $hotel['name1'] ) {
        echo "  <div class='reservation'>\n";
        echo "    <div class='roomtype'>{$hotel['name1']} ({$hotel['nr1']})</div>\n";
        echo "    <div class='rate'>{$hotel['rates1']}</div>\n";
        echo "  </div>\n";
    }
    if (isset($hotel['name2']) && $hotel['name2'] ) {
        echo "  <div class='reservation'>\n";
        echo "    <div class='roomtype'>{$hotel['name2']} ({$hotel['nr2']})</div>\n";
        echo "    <div class='rate'>{$hotel['rates2']}</div>\n";
        echo "  </div>\n";
    }
    echo "    <div class='deadline'>deadline: {$hotel['deadline']}</div>\n";
    echo "</div>\n";
}
?>
