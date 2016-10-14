<?php


$directory = "photos/";

$images = glob("" . $directory . "*.JPG");
$imgs = '';
foreach($images as $image){ $imgs[] = "$image"; }

# print_r($images);
?>



<article>

<h1>Pictures</h1>


<?php

foreach ($imgs as $img) {
  echo "
  <p>
    <a href='$img'  data-lightbox='img_cat' data-title='$img'>
      <img src='$img' height='200' alt='conference image'/>
    </a>
  </p>";
}

 ?>



</article>
