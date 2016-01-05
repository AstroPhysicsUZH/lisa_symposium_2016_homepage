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
