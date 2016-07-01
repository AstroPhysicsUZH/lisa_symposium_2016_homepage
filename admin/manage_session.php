<?php
require "lib/header.php";



if (!empty($_POST)) {

    print "<h1>Processing changes</h1>";
    print_r($_POST);

    if (array_key_exists('sid', $_GET)) {
        $sid = $_GET['sid'];
    }
    else {$sid=FALSE;}

    if (array_key_exists("action", $_POST)) {

        $action = $_POST["action"];
        unset($_POST["action"]);

        print_r($action);

        if ($action=="save") {

            $id = $_POST['id'];

            $atp = $_POST['acceptedType'];
            $dat = $_POST['date'] . " " . $_POST['time'];
            $dur = $_POST['duration'];
            $ppl = $_POST['posterPlace'];

            $stmtstr = "UPDATE {$tableName} SET
                acceptedType = :atp,
                presentationSlot = :dat,
                presentationDuration = :dur,
                posterPlace = :ppl
                WHERE id = :id;";
            $stmt = $db->prepare($stmtstr);
            $stmt->bindParam(':id', $id , PDO::PARAM_INT);
            $stmt->bindParam(':atp', $atp , PDO::PARAM_INT);
            $stmt->bindParam(':dat', $dat , PDO::PARAM_STR);
            $stmt->bindParam(':dur', $dur , PDO::PARAM_INT);
            $stmt->bindParam(':ppl', $ppl , PDO::PARAM_STR);

            $res = $stmt->execute();

            $target = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . ($sid ? "?sid=$sid" : "?_=_") . "#frmid" . $id; # ?_=_ part is needed to trigger actual reload
            print "<script type='text/javascript'>window.location = '$target';</script>";
        }
        else {
            print "huch??";
            require "lib/footer.php";
            die();
        }

    }

    $db = null;
    require "lib/footer.php";
    die();
}
?>






<?php

if (array_key_exists('sid', $_GET)) {
    $sid = $_GET['sid'];
    $stmt = $db->prepare( "SELECT * FROM {$sessionsTable} WHERE id=:sid");
    $stmt->bindParam(':sid', $sid , PDO::PARAM_INT);
    $stmt->execute();
    $s = $stmt->fetch(PDO::FETCH_OBJ);

    # check if one simply modified the get parameter... admins are allowed to do so thou
    if ( is_null($s) || !$s ) {
        print "nice try, but you murdered me... die() [index out of range]";
        die();
    }
    if ( !in_array($USER->username, explode(";", $s->orgas)) &&  # an unauthorised user access existing stuff
         !in_array($USER->role, $special_power_roles) ) { # the user has super powers or asked nicely
        print "nice try, but you murdered me... die() [access denied]";
        die();
    }

    $slots = explode(";",$s->timeslots);
    $start_datetime = explode("/", $slots[0]);
    $start_date = explode(" ", $start_datetime[0])[0];


    print "<h1>Manage Your Session:</h1>";
    print "<p style='text-align:right;'><code>[{$s->shortName}]</code> {$s->description}</p>";

    $stmtstr = "SELECT
                    id, title, firstname, lastname, email, affiliation,
                    talkType, presentationTitle, coauthors, abstract, presentationCategories,
                    assignedSession, isPresentationAccepted, acceptedType,
                    presentationSlot, presentationDuration, posterPlace
                FROM {$tableName}
                WHERE assignedSession=:sid;";
    $stmt = $db->prepare($stmtstr);
    $stmt->bindParam(':sid', $sid , PDO::PARAM_INT);
    $stmt->execute();
    $presentations = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

    <h2>Overview / Timeline</h2>
    <p>
        Please be patient, I'll implement a nice little graphical overview in the next
        few days...
    </p>
    <div id="timeline_container">

    </div>

    <script type="text/javascript">
$(function(){
    var container = document.getElementById('timeline_container');

    var items = new vis.DataSet([
        {id: 'A', content: 'Period A', start: '2016-09-01', end: '2016-09-05', type: 'background'},
        {id: 'B', content: 'Period B', start: '2016-09-09', end: '2016-09-30', type: 'background', className: 'negative'},

        {id: 1, content: 'item 1', start: '2016-09-20'},
        {id: 2, content: 'item 2', start: '2016-09-14'},
        {id: 3, content: 'item 3', start: '2016-09-18'},
        {id: 4, content: 'item 4', start: '2016-09-16', end: '2016-09-19'},
        {id: 5, content: 'item 5', start: '2016-09-15'},
        {id: 6, content: 'item 6', start: '2016-09-17'}
    ]);

    // Configuration for the Timeline
    var options = {
        editable: true,
        min: new Date("2016-09-01"),
        max: new Date("2016-09-30"),
    };

    var groups = [
      {
        id: 1,
        content: 'Group 1'
        // Optional: a field 'className', 'style'
      }
      // more groups...
    ];

    var timeline = new vis.Timeline(container, items, options);

    timeline.on('rangechanged', function (properties) {
        console.log('rangechanged', properties);
    });
})
    </script>

    <h2>Presentations</h2>

<?php
    foreach($presentations as $p) {
        if ($p->talkType > 0) {$type = ($p->talkType == 1 ? "talk" : "poster");}
        else {$type = "none";}
        print "<!-- {$p->presentationSlot} -->";

        if (isset($p->presentationSlot)) {
            $ptime = explode(" ", $p->presentationSlot)[1];
        }
        else {$ptime = "";}
?>

        <form id="frmid<?=$p->id?>"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            method="post">
            <h3 class="presentation"><code>[<?=$p->id?>]</code> <?=$p->presentationTitle?></h3>
            <p class="summary">
                Type: <?=$type?> <br />
                By: <?=$p->title?> <?=$p->firstname?> <?=$p->lastname?> (<?=$p->email?>)<br />
                <i><?=$p->affiliation?></i><br />
                <small>Coauthors: <?=$p->coauthors?></small><br />
            </p>
            <p class="abstract">
                <code><?=nl2br($p->abstract) ?></code>
            </p>

            <div class="inputarea">
<?php
                    if (isset($p->isPresentationAccepted) && !$p->isPresentationAccepted) {
                        print "was rejeced <input type='submit' name='action' value='reconsider' >";
                    }
                    else {
                        $s0=''; $s1=''; $s2='';
                        if ($p->acceptedType == 1) {$s1=' selected';}
                        elseif ($p->acceptedType == 2) {$s2=' selected';}
                        else {$s0=' selected';}
?>
                <div class="half">
                    <label class="left">Accept as:
                        <select name="acceptedType" size="1">
                            <option value='-1'<?=$s0?>>-- not defined --</option>
                            <option value='1'<?=$s1?>>talk</option>
                            <option value='2'<?=$s2?>>poster</option>
                        </select>
                    </label>
                    <br>
                    <input class="save" type="submit" name="action" value="save" >
                    <input class="warn" type="submit" name="action" value="REJECT" >
                </div>
                <div class="half">
                    <label class="left">
                        <small>[talk] starting time (24h):</small>
                        <input class="short" name="time" type="text" value="<?=$ptime?>"
                            placeholder="14:15" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                            title="Enter a time in 24h HH:mm format, like 14:15" >
                    </label><br>
                    <label class="left">
                        <small>[talk] duration in minutes:</small>
                        <input class="short" name="duration" type="numeric" min=0 max=240
                            placeholder="25" value="<?=$p->presentationDuration?>">
                    </label><br>
                    <label class="left">
                        <small>[poster] number / place:</small>
                        <input class="short" name="posterPlace" type="numeric" min=0 max=240
                            value="<?=$p->posterPlace?>">
                    </label>
                </div>
<?php               } ?>
            </div>
            <input type="hidden" name="date" value="<?=$start_date?>" >
            <input type="hidden" name="id" value="<?=$p->id?>" >
        </form>

<?php
    }
?>


<script>
    $(function(){
    })
</script>



<?php
# -----------------------------------------------------------------------------
} else {
?>

    <h1>Manage Your Sessions</h1>
    <h2>Select a session to manage:</h2>

    <ul class="pagemenu">

<?php

    $all_sessions = $db->query( "SELECT * FROM {$sessionsTable}")->fetchAll(PDO::FETCH_OBJ);
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];


    foreach($all_sessions as $s) {
        if (in_array($_SESSION["username"], explode(';', $s->orgas)) ||
            in_array($USER->role, $special_power_roles)) {
            print "<li><a href='{$url}?sid={$s->id}'><code>[{$s->shortName}]</code> {$s->description}</a></li>";
        }
    }
}
?>
    </ul>

<?php require "lib/footer.php" ?>
