<?php
require_once "lib/header.php";
require "../data/events.php";


foreach($PRESENTATION_TYPES as $tid => $typestr) {

    print "<h1>" . $typestr ."</h1><br>\n";

    foreach ($sessions as $s) {
        $sid = $s->id;
        print "<h2>".$s->shortName . ") " . $s->description . "</h2><br>\n";

        foreach($all_submissions as $sub) {
            # print_r($sub);
            if (   $sub->acceptedType == $tid
                && $sub->assignedSession == $sid) {
                    print $sub->id . "<br>\n";
            }
        }
    }
}
