<?php

$menuitems = array(
    'overview',
    'programme',
    'accomodation',
    'travel',
    'registration'
);

function print_menu($page) {

    $menuitems = array(
        'overview',
        'programme',
        'accomodation',
        'travel',
        'registration'
    );

    
    foreach ($menuitems as $item) {
        print "    <li";
        if ($page == $item) {
            print " class='active'";
        }
        print "><a href='?page=$item'>$item</a></li>\n";
    }

/*
    <li class="active"><a href="?page=overview">overview</a></li>
    <li><a href="?page=programme">programme</a></li>
    <li><a href="?page=accomodation">accomodation</a></li>
    <li><a href="?page=travel">travel</a></li>
    <li><a href="?page=registration">registration</a>
*/
}
