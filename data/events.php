<?php

/**
 * assumes the header file is already loaded
 *
 * provides $presentations, $breaks, $posters, $specialevents
 */


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
            WHERE acceptedType=".PRESENTATION_TYPE_POSTER.";" ;

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
    ['Registraton open', '2016-09-05T08:00:00', '2016-09-05T08:45:00', ''],
    ['Welcome Talk', '2016-09-05T08:45:00', '2016-09-05T09:00:00', ''],
    ['Joint eLISA and L3ST consortium meeting', '2016-09-07T14:00:00', '2016-09-07T16:30:00', ''],
    ['Hike to Dinner', '2016-09-07T17:00:01', '2016-09-07T18:00:00', join('<br>',[
        'Hike to diner place',
        '(in case of nice weather, ask Rafael)',
        '<hr>' .
        'Meetingpoint: tram station "Triemli"',
        '(end station of nr 14)' ,
        'Meeting time: 17:00',
        '<hr>'.
        'Duration: 1h',
        'Ascent: 400m',
        'Length: 4km',
        'HikeNr: 47',
        'Link: http://www.wanderland.ch/de/routen/etappe-01211.html' ])
    ],
    ['Transport to Dinner', '2016-09-07T17:00:00', '2016-09-07T18:00:00', join('<br>',[
        'Public transport',
        '<hr>' .
        'Tram Nr 14:',
        'from: 17:06 Milchbuck',
        'to: 17:16 Bahnhofplatz/HB',
        '<hr>' .
        'Train S10 on Track 22:',
        'from: 17:35 Zurich HB SZU',
        'to: 17:55 Uetliberg'])
    ],
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

?>
