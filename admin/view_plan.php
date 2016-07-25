<?php
require_once "lib/headerphp.php";


$stmtstr = "SELECT * FROM {$sessionsTable}";
$sessions = $db->query( $stmtstr )->fetchAll(PDO::FETCH_OBJ);

$plenary_sid = NULL;
foreach($sessions as $s) {
    if ($s->categories=="plenary") {
        $plenary_sid = $s->id;
    }
}
#print_r($sessions);
#print $plenary_sid;

$stmtstr = "SELECT
                id, title, firstname, lastname, email, affiliation,
                talkType, presentationTitle, coauthors, abstract, presentationCategories,
                assignedSession, isPresentationAccepted, acceptedType,
                presentationSlot, presentationDuration
            FROM {$tableName}
            WHERE acceptedType=" . PRESENTATION_TYPE_TALK . "
                AND presentationDuration>0
                AND presentationSlot<>''
            ORDER BY presentationSlot ASC;" ;

$presentations = $db->query( $stmtstr )->fetchAll(PDO::FETCH_OBJ);

$stmtstr = "SELECT
                id, title, firstname, lastname, email, affiliation,
                talkType, presentationTitle, coauthors, abstract, presentationCategories,
                assignedSession, isPresentationAccepted, acceptedType,
                presentationSlot, presentationDuration
            FROM {$tableName}
            WHERE acceptedType=".PRESENTATION_TYPE_POSTER." AND presentationSlot<>'';" ;

$posters = $db->query( $stmtstr )->fetchAll(PDO::FETCH_OBJ);

# group by day
foreach($presentations as $p) {
    #print_r($p);

    $p->name = substr($p->firstname,0,1) . ". " . $p->lastname;
    $p->start = new DateTime($p->presentationSlot);
    try {
        $dur = new DateInterval('PT'.$p->presentationDuration.'M');
    }
    catch (Exception $e) {
        $dur = new DateInterval('PT'.'15'.'M');
        echo "<!-- error with duration of {$p->id} -->\n";
    }
    $end = new DateTime($p->presentationSlot);
    $p->end = $end->add($dur);
    $p->is_plenary = ($p->assignedSession == $plenary_sid ? TRUE : FALSE);
    #print_r($p);
}


$breaks_list = [
    ['Coffee Break', '2016-09-05T10:30:00', '2016-09-05T11:00:00', ''],
    ['Coffee Break', '2016-09-06T10:30:00', '2016-09-06T11:00:00', ''],
    ['Coffee Break', '2016-09-07T10:30:00', '2016-09-07T11:00:00', ''],
    ['Coffee Break', '2016-09-08T10:30:00', '2016-09-08T11:00:00', ''],
    ['Coffee Break', '2016-09-09T10:30:00', '2016-09-09T11:00:00', ''],

    ['Coffee Break', '2016-09-05T16:30:00', '2016-09-05T17:00:00', ''],
    ['Coffee Break', '2016-09-06T16:30:00', '2016-09-06T17:00:00', ''],
    ['Coffee Break', '2016-09-08T16:30:00', '2016-09-08T17:00:00', ''],

    ['Lunch Break', '2016-09-05T13:00:00', '2016-09-05T14:30:00', ''],
    ['Lunch Break', '2016-09-06T13:00:00', '2016-09-06T14:30:00', ''],
    ['Lunch Break', '2016-09-07T13:00:00', '2016-09-07T14:00:00', ''],
    ['Lunch Break', '2016-09-08T13:00:00', '2016-09-08T14:30:00', ''],
    ['Lunch Break', '2016-09-09T13:00:00', '2016-09-09T14:30:00', ''],
];

$special_events_list = [
    ['Registraton opens', '2016-09-05T08:00:00', '2016-09-05T08:45:00', ''],
    ['Welcome Talk', '2016-09-05T08:45:00', '2016-09-05T09:00:00', ''],
    ['Joint eLISA and L3ST consortium meeting', '2016-09-07T14:00:00', '2016-09-07T16:30:00', ''],
    ['Apero & Dinner', '2016-09-07T18:00:00', '2016-09-07T23:00:00', ''],
    ['Farewell Talk', '2016-09-09T12:30:00', '2016-09-09T13:00:00', 'by K. Danzmann'],
];

$breaks = [];
foreach($breaks_list as $bl) {
    $breaks[] = (object) [
        'name' => $bl[0],
        'start' => new DateTime($bl[1]),
        'end' =>   new DateTime($bl[2]),
        'description' => $bl[3]
    ];
};
foreach ($breaks as $b) {
    $b->is_break = TRUE;
    $b->is_no_talk = TRUE;
}


$specialevents = [];
foreach($special_events_list as $se) {
    $specialevents[] = (object) [
        'name' => $se[0],
        'start' => new DateTime($se[1]),
        'end' =>   new DateTime($se[2]),
        'description' => $se[3]
    ];
};
foreach ($specialevents as $se) {
    $se->is_special = TRUE;
    $se->is_no_talk = TRUE;
}


#print_r($presentations);
$fmt = 'Y-m-d\TH:i:s';

?>
<html>
<head>
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="../css/fullcalendar.min.css">
    <script src="../js/jquery-1.12.1.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/fullcalendar.min.js"></script>

    <script src="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css">

<style>

.time {
    font-size: 80%;
    color: #888;
}

.title {
    font-style: italic;
}

.notalk {
    color: #888;
}

ul {
    list-style-type: none;
}



</style>
<script>
$(document).ready(function() {

    // special events
    var evtSrcSpcl = { events: [
    <?php
    foreach ($specialevents as $se) {
        print <<<EOT
        {
            start: '{$se->start->format($fmt)}',
            end:   '{$se->end->format($fmt)}',
            title: '{$se->name}',
            description: '{$se->description}'
        },
EOT;
    }
?>
    ], color: '#8888ff', textColor: 'black'};

    // Enter recurring breaks here (PHP code following)
    var evtSrcsBrks = { events: [
    <?php
    foreach ($breaks as $b) {
        print <<<EOT
        {
            start: '{$b->start->format($fmt)}',
            end:   '{$b->end->format($fmt)}',
            title: '{$b->name}'
        },
EOT;
    }
    ?>
    ], color: '#ff8888', textColor: 'black'};

    // Enter Plenary Talks
    var evtSrcsCTalks = { events: [
    <?php
    foreach($presentations as $p) {
        #print "//{$p->id}";
        if ($p->is_plenary) {
            print "        {
                start: '{$p->start->format($fmt)}',
                end:   '{$p->end->format($fmt)}',
                title: '{$p->name}',
                ptitle: '{$p->presentationTitle}',
                name: '{$p->name}',
                description: " . json_encode($p->abstract) . "
            },\n";
        }
    }
    ?>

    ], color:'#88ff88', textColor:'black', borderColor:'#008800' };

    // Enter Parallelsessions
    var evtSrcsPTalks = { events: [
    <?php
    $fmt = 'Y-m-d\TH:i:s';
    foreach($presentations as $p) {
        #print "//{$p->id}";
        if (!$p->is_plenary) {
            print "        {
                start: '{$p->start->format($fmt)}',
                end:   '{$p->end->format($fmt)}',
                title: '{$p->name}',
                ptitle: '{$p->presentationTitle}',
                name: '{$p->name}',
                description: " . json_encode($p->abstract) . "
            },\n";
        }
    }
    ?>

        ], color:'#ffff88', textColor:'black', borderColor:'#aaaa00' };


    $('#calendar').fullCalendar({
        weekends: false, // will hide Saturdays and Sundays

        height: 'auto',

        defaultDate: '2016-09-05',
        defaultView: 'agendaWeek',
        editable: false,

        header: {
            left: '',
            center: '',
            right: ''
        },

        views: {
            agenda: {
                scrollTime: '08:00:00',
                slotLabelFormat: 'H:mm',
                minTime: "08:00:00",
                maxTime: "19:30:00",
                columnFormat: "ddd D",
                slotDuration: '00:20:00'
            }
        },

        eventRender: function(event, element) {
            if (event.ptitle) {
                element.find(".fc-content").append("<div class='fc-ptitle'>"+event.ptitle+"</div>");
            }
            if (event.ptitle) {
                var txt = "<b>" + event.ptitle + "</b><br>\n";
                txt += "<i>" + event.name + "</i><br><br>\n";
                txt += event.description;
            }
            else if (event.description) {
                var txt = event.description;
            }
            else { var txt="";}
            element.qtip({
                content: {
                    text: txt
                },
                position: {
                    viewport: $(window)
                }
            });
        },

        allDaySlot: false,
        eventSources: [evtSrcsBrks, evtSrcsCTalks, evtSrcsPTalks, evtSrcSpcl],
        timeFormat: 'H:mm',
    })
});
</script>

</head>
<body>
    <h1>Programme</h1>
    <div id='calendar'></div>

    <h1>List</h1>

<?php
$fmt = 'H:i';
$cur = NULL;

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
        print "<h2>$day</h2>\n";
        print "<ul>\n";
        $cur = $day;
    }
    #print "<!--  " . $day . "  " . $cur . "-->\n";

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
        print <<<EOT
        <span class="author">{$p->name}</span>
        &mdash;
        <span class="title">{$p->presentationTitle}</span>

EOT;
    }
    print "    </li>\n";
}
print "</ul>\n";

?>
</body>
</html>
