<article>
  <h1>Welcome</h1>
  <p>
     The eleventh international LISA Symposium on recent developments gravitational waves, LISA pathfinder and LISA in general will take place at the University of Zurich, Switzerland September 5 &ndash; 9, 2016.
  </p>
  <p>
    Among others, we will discuss these preliminary topics:
  </p>
  <ul>
    <li>First results of LISA Pathfinder</li>
    <li>Further development of LISA</li>
    <li>Overview of ground based Gravitational Wave detection</li>
    <li>Precision tests of GR (MicroScope)</li>
  </ul>
  
  <h2>News</h2>
  <ul>
<?php
  $news = get_news();
  foreach ($news as $v) {
    $strdate = $v['date'];
    echo "<li><span class='date'>$strdate</span> {$v['comment']}</li>";
  }
?>
  </ul>

</article>
