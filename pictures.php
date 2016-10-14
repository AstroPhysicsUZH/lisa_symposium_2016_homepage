<?php


$directory = "photos/";

$images1 = glob("" . $directory . "*.jpg");
$images2 = glob("" . $directory . "*.JPG");
$imgs = '';
foreach($images1 as $image){ $imgs[] = "$image"; }
foreach($images2 as $image){ $imgs[] = "$image"; }

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
