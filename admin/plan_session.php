<?php
require_once "lib/headerphp.php";

if (array_key_exists('sid', $_GET)) {
    $sid = $_GET['sid'];
    $sid_is_set = TRUE;

    $stmt = $db->prepare( "SELECT * FROM {$sessionsTable} WHERE id=:sid");
    $stmt->bindParam(':sid', $sid , PDO::PARAM_INT);
    $stmt->execute();
    $s = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$s) {
        print "wrong sid";
        die;
    }

    if ( !in_array($USER->username, explode(";", $s->orgas)) &&  # an unauthorised user access existing stuff
         !in_array($USER->role, $special_power_roles) ) { # the user has super powers or asked nicely
        print "nice try, but you murdered me... die() [access denied]";
        die();
    }

    # parse the timeslots.. we'll use it anyways quite often
    # timeslots have format "2016-09-05 08:00/12:00; ..."
    if (!empty($s->timeslots)){
        $slots = explode(";",$s->timeslots);
        $slot = $slots[0]; # for the moment, we only support one timeslot per session
        $timeslots = [];

        $startend_datetime = explode("/", $slot);

        $start_datetime = $startend_datetime[0];
        $start_date = explode(" ", $startend_datetime[0])[0];
        $end_datetime = $start_date . " " . $startend_datetime[1];

        $start_dt = new DateTime($start_datetime);
        $end_dt   = new DateTime($end_datetime);

        $timeslots[] = [$start_dt, $end_dt];
        $dt_are_set = TRUE;
    }
    else {
        $dt_are_set = FALSE;
    }
}
else {
    $sid_is_set=FALSE;
}

?>



<html>
<head>
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="../js/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css">
    <script src="../js/jquery-1.12.1.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	}

	#wrap {
		width: 1100px;
		margin: 0 auto;
        border: black solid 1px;
	}

	#leftlists {
		float: left;
		width: 150px;
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
	}

    .list {
        padding: 5px;
        margin: 0;
        border: 1px solid black;
        min-height: 5em;
        list-style-type: none;

    }

    .list li {
        margin: 0;
        padding: 5px;
        border: 1px solid black;
        background-color: #ccc;
        cursor: pointer;
    }

	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}

	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
	    border: 1px solid black;
		float: right;
		width: 900px;
	}

</style>
<script>
    $(function(){
        $('.list').sortable({
            connectWith: '.list',
            receive: function( event, ui ) {
                console.log("received", event, ui);

            }
        });
    });
</script>
</head>
<body>
<div id='wrap'>
    <h1>Planning of session</h1>
    <div id="leftlists">
        <p>drag and drop items to calendar or into lists</p>
        <h3>not classified yet...</h3>
        <ul id='submissions' class="list">
            <li>submission</li>
        </ul>
        <h3>Posters</h3>
        <ul id='posters' class="list">
            <li>poster</li>
        </ul>
        <h3>Rejected</h3>
        <ul id='rejected' class="list">
            <li>rej</li>
        </ul>
    </div>
    <div id='calendar'>
        calendar
    </div>
    <div style='clear:both'></div>
</div>
</body>
</html>
