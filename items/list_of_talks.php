<?php
require "data/events.php";

?>

<h2 id='listoftalks'>List of Talks</h2>


<?php

$fmt = 'H:i';
$cur = NULL;
$cid = 0;

$all = array_merge($presentations, $breaks);

function cmp($a, $b) {
    $fmt = 'Y-m-d\TH:i:s';
    return strcmp($a->start->format($fmt), $b->start->format($fmt));
}


usort($all, "cmp");

foreach($all as $p) {
    #print "//{$p->id}";
    #if (!$p->is_plenary) { continue; }
    $day = $p->start->format('l jS \of F Y');

    if (!($day==$cur)) {
        if (!is_null($cur)){print "</ul>\n";}
        print "<h3>$day</h3>\n";
        print "<ul class='prog speakers'>\n";
        $cur = $day;
    }
    #print "<!--  " . $day . "  " . $cur . "-->\n";
    if (count($chairs) > $cid && $p->start > $chairs[$cid]['date']) {
        print "<h4 class='chair'>Chairperson: " . $chairs[$cid]['chair'] . "</h4>";
        $cid += 1;
    }


    print <<<EOT
    <li>
        <span class='time'>{$p->start->format($fmt)} &ndash; {$p->end->format($fmt)}:</span>

EOT;
    if (isset($p->is_no_talk) && $p->is_no_talk) {
        print <<<EOT
        <span class="notalk">{$p->name}</span>

EOT;
    }
    else {
        $pid = sprintf("%03u", $p->id);
#        <span class="affil">({$p->affiliation})</span>
        print <<<EOT
        <span class='data'>
            <span class="author">{$p->name}</span>
            <!--&mdash;-->
            <a class="title linked" onclick="
                document.getElementById('mod_abstr_{$pid}').style.display = 'block';
                ">
                &lsaquo;&nbsp;{$p->presentationTitle}&nbsp;&rsaquo;
            </a>
        </span>

        <div id="mod_abstr_{$pid}" class="modal_abstract" onclick="
            document.getElementById('mod_abstr_{$pid}').style.display = 'none';
            ">
            <div class="container">
                <a class="close" onclick="
                    document.getElementById('mod_abstr_{$pid}').style.display = 'none';
                    ">
                    [ close ]
                </a>
                <p onclick="
                    var event = arguments[0] || window.event;
                    if (event.stopPropagation) { event.stopPropagation(); }
                    else { event.cancelBubble = true; }
                    ">
                    <span class="mod_name">{$p->firstname} {$p->lastname}</span>
                    <span class="mod_aff">{$p->affiliation}</span>
                    <span class="mod_title">{$p->presentationTitle}</span>
                    {$p->abstract}
                </p>
            </div>
        </div>


EOT;
    }
    print "    </li>\n";
}
print "</ul>\n";

?>
