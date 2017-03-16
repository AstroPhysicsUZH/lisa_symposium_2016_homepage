<?php

require_once "lib/headerphp.php";
require_once "../data/events.php";
require_once "../lib/app.php";


$fmt = 'H:i';
$cur = NULL;
$cid = 0;

$all = array_merge($presentations); #, $breaks);

function cmp($a, $b) {
    $fmt = 'Y-m-d\TH:i:s';
    return strcmp($a->start->format($fmt), $b->start->format($fmt));
}


usort($all, "cmp");


foreach($all as $p) {
    #print "//{$p->id}";
    #if (!$p->is_plenary) { continue; }
    $day = $p->start->format('l\, jS \of F Y');

    if ((count($chairs) > $cid && $p->start > $chairs[$cid]['date'] && $cid>0)
        || !($day==$cur)  && $cid>0 ) {
        print "\\end{pdesc}\n\n";
    }


    if (!($day==$cur)) {
        print "\section*{{$day}}\n\n";
        $cur = $day;
    }
    #print "<!--  " . $day . "  " . $cur . "-->\n";
    if (count($chairs) > $cid && $p->start > $chairs[$cid]['date']) {

        print "\chair{" . $chairs[$cid]['chair'] . "}\n";
        $cid += 1;

        print "\begin{pdesc}\n";
    }

    if (isset($p->is_no_talk) && $p->is_no_talk) {
    }
    else {
        $pid = sprintf("%03u", $p->id);
#        <span class="affil">({$p->affiliation})</span>
        $name = $p->name;
        print "    \item[{$name}]{{$p->presentationTitle}}\n";
    }
}
print "\\end{pdesc}\n\n";

?>
