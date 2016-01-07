<article>

<h1>Hotels</h1>

<p>
  We recommend the following hotels.<br>
  For more choice consult <a href="https://www.zuerich.com/en/visit/accommodation-hotel-bed-and-breakfast-hostel"> the webpage of Zurich tourism</a>.
</p>

<p class="warning">
  Please make sure to book <b>way in advance</b>.<br>
  September is a crowded time in Zurich and Hotels are likely to book out very early.
</p>


<?php
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
?>


</article>