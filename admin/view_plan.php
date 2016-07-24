<?php
require_once "lib/headerphp.php";


$stmtstr = "SELECT
                id, title, firstname, lastname, email, affiliation,
                talkType, presentationTitle, coauthors, abstract, presentationCategories,
                assignedSession, isPresentationAccepted, acceptedType,
                presentationSlot, presentationDuration
            FROM {$tableName}
            WHERE acceptedType=".PRESENTATION_TYPE_TALK.";" ;

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
    $dur = new DateInterval('PT'.$p->presentationDuration.'M');
    $end = new DateTime($p->presentationSlot);
    $p->end = $end->add($dur);
}

#print_r($presentations);

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

<script>
$(document).ready(function() {

    // Enter recurring breaks here (PHP code following)
    var evtSrcsBrks = { events: [

        { start:'2016-09-07T10:30:00', end:'2016-09-07T11:00:00', title:'Break' },
        { start:'2016-09-07T13:00:00', end:'2016-09-07T14:00:00', title:'Lunch Break' },

        // Enter singular break events here
        { start:'2016-09-09T10:30:00', end:'2016-09-09T11:00:00', title:'Break' },
        { start:'2016-09-09T13:00:00', end:'2016-09-09T14:00:00', title:'Lunch Break' },

        { start:'2016-09-07T18:00:00', end:'2016-09-07T23:00:00', title:'Apero and Conference Dinner' },
    ], color: '#ff8888', textColor: 'black'};

    // Enter Plenary Talks
    var evtSrcsCTalks = { events: [

<?php
foreach($presentations as $p) {
    print "//{$p->id}";
    $fmt = 'Y-m-d\TH:i:s';
    print "
    {
        start: '{$p->start->format($fmt)}',
        end:   '{$p->end->format($fmt)}',
        title: '{$p->name} \\n {$p->presentationTitle}',
        description: " . json_encode($p->abstract) . "
    },\n";
}
?>
        // MO
        { start:'2016-09-05T09:00:00', end:'2016-09-05T09:15:00', title:'Opening' },
        { start:'2016-09-05T09:15:00', end:'2016-09-05T13:00:00', title:'Plenary\nTalks' },
        // Di
        { start:'2016-09-06T09:00:00', end:'2016-09-06T13:00:00', title:'Plenary Talks' },
        // Mi
        { start:'2016-09-07T09:00:00', end:'2016-09-07T13:00:00', title:'Plenary Talks' },
        { start:'2016-09-07T14:00:00', end:'2016-09-07T17:00:00', title:'Joint eLISA and L3ST consortium meeting' },
        // Do
        { start:'2016-09-08T09:00:00', end:'2016-09-08T13:00:00', title:'Plenary Talks' },
        // Fr
        { start:'2016-09-09T09:00:00', end:'2016-09-09T13:00:00', title:'Plenary Talks' },
    ], color:'#88ff88', textColor:'black', borderColor:'#008800' };

    // Enter Parallelsessions
    var evtSrcsPTalks = { events: [
        { start:'2016-09-05T14:30:00', end:'2016-09-05T19:00:00', title:'Contributed Talks' },

        { start:'2016-09-06T14:30:00', end:'2016-09-06T19:00:00', title:'Contributed Talks' },

        { start:'2016-09-08T14:30:00', end:'2016-09-08T19:00:00', title:'Contributed Talks' },

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
                scrollTime: '08:30:00',
                slotLabelFormat: 'H:mm',
                minTime: "07:30:00",
                maxTime: "20:30:00",
                columnFormat: "ddd D"
            }
        },

        eventRender: function(event, element) {
            element.find(".fc-content").append("<div class='fc-abstract'>abstract</div>");
            element.qtip({
                content: {
                    text: "blabla" + event.description
                }
            });
        },

        allDaySlot: false,
        eventSources: [evtSrcsBrks, evtSrcsCTalks, evtSrcsPTalks],
        timeFormat: 'H:mm',
    })
});
</script>

</head>
<body>
    <h1>Programme</h1>
    <div id='calendar'></div>

    <h1>List</h1>

</body>
</html>
