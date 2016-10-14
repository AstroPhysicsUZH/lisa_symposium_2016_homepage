<?php


$directory = "photos/";

$images1 = glob("" . $directory . "*.jpg");
$images2 = glob("" . $directory . "*.JPG");
$imgs = '';
foreach($images1 as $image){ $imgs[] = "$image"; }
foreach($images2 as $image){ $imgs[] = "$image"; }

# print_r(basename($images2[0]));
?>



<article>

<h1>Pictures</h1>


<?php

foreach ($imgs as $img) {
  echo "
  <p>
    <a href='{$img}'>
      <img src='{$directory}thumbnail/" . basename($img) ."' height='200' alt='conference image'/>
    </a>
  </p>";
}

 ?>



</article>
