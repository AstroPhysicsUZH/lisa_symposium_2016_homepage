<?php require "lib/header.php";

/**
allows a admin or MasterORGA (morga) to create parallel sessions
and assign timeslots and organisators (orga) to it

this page really needs some love.. css styiling would be great..
but it's only ever seen by me, so it didn't happen up to now...
**/


// $db is already open!

/*
    this table has:
    - orgas: comma separated admin names
    - timeslots: comma separated start and end dates! (multiple pairs possible)
*/
if (! tableExists($db, $sessionsTable) ) {
    $db->exec(  "CREATE TABLE IF NOT EXISTS {$sessionsTable} (
                    id INTEGER PRIMARY KEY,
                    shortName TEXT,
                    description TEXT,
                    orgas TEXT,
                    timeslots TEXT
                )"
        );
}



if (!empty($_POST)) {

    print "<h1>Processing changes</h1>";
    print_r($_POST);

    if (array_key_exists("action", $_POST)) {

        $action = $_POST["action"];
        unset($_POST["action"]);

        if ($action=="new") {
            $sname = $_POST['shortName'];
            $desc = $_POST['description'];
            $orgas = "";
            $timeslots = "";
            $insert = "INSERT INTO {$sessionsTable} (shortName, description, orgas, timeslots) ";
            $insert .= "VALUES ('$sname', '$desc', '$orgas', '$timeslots') ";
            $db->exec($insert);

            $target = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
            print "<script type='text/javascript'>window.location = '$target';</script>";
        }

        else if ($action="edit") {
            $id = $_POST['id'];
            $btn = $_POST['btn'];

            if ($btn=="edit") {
                $sname = $_POST['shortName'];
                $desc = $_POST['description'];
                $orgas = $_POST['orgas'];
                $timeslots = $_POST['timeslots'];

                $stmtstr = "UPDATE {$sessionsTable} SET
                    shortName = :sname,
                    description = :desc,
                    orgas = :orgas,
                    timeslots = :ts
                    WHERE id = :id;";
                $stmt = $db->prepare($stmtstr);
                $stmt->bindParam(':id', $id , PDO::PARAM_INT);
                $stmt->bindParam(':sname', $sname , PDO::PARAM_STR);
                $stmt->bindParam(':desc', $desc , PDO::PARAM_STR);
                $stmt->bindParam(':orgas', $orgas , PDO::PARAM_STR);
                $stmt->bindParam(':ts', $timeslots , PDO::PARAM_STR);

                $res = $stmt->execute();

                $target = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
                print "<script type='text/javascript'>window.location = '$target';</script>";
            }
            else if ($btn == "DELETE") {
                $stmtstr = "DELETE FROM {$sessionsTable} WHERE id = :id";
                $stmt = $db->prepare($stmtstr);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $res = $stmt->execute();

                $target = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
                print "<script type='text/javascript'>window.location = '$target';</script>";

            }
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

// ----------------------------------------------------------------------------

?>



<h1>Assign Session</h1>

<h2>New Session</h2>

<form id="frm_new"
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
    method="post">
    <div>
        <label for="shortName" class="left">short name</label>
        <input
            id="shortName" type="text" name="shortName"
            required placeholder="shortHand">
    </div>
    <div>
        <label for="description" class="left">description</label>
        <input
            id="description" type="text" name="description"
            required placeholder="Enter description">
    </div>
    <input id="action" type="hidden" name="action" value="new" >
    <input id="btn_save" type="submit" value="SAVE" class="bigsavebtn" >
</form>


<h2>Modify Existing Sessions</h2>

<h3>currently registered Organisators</h3>
<ul>
<?php

    $all_users = $USER->database->query("SELECT username, email, role FROM users")->fetchAll(PDO::FETCH_OBJ);
    foreach($all_users as $u) {
        if ($u->role == 'orga') {
            print "<li>".$u->username . " (".$u->email . ") </li>";
        }
    }
?>
</ul>

<?php
    $all_sessions = $db->query( "SELECT * FROM {$sessionsTable}")->fetchAll(PDO::FETCH_OBJ);
    foreach($all_sessions as $s) {
?>
    <h3><?=$s->shortName?>: <?=$s->description?> (<?=$s->id?>)</h3>
    <form id="frm_<?=$s->id?>"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="post">
        <div>
            <label for="short" class="left">short description</label>
            <input
                id="shortName" type="text" name="shortName"
                placeholder="shortHand"
                value="<?=$s->shortName?>">
        </div>
        <div>
            <label for="description" class="left">description</label>
            <input
                id="description" type="text" name="description"
                placeholder="Enter description"
                value="<?=$s->description?>">
        </div>
        <div>
            <label for="orgas" class="left">orgas</label>
            <input
                id="orgas" type="text" name="orgas"
                placeholder="Enter orgas"
                value="<?=$s->orgas?>">
        </div>
        <div>
            <label for="timeslots" class="left">timeslots</label>
            <input
                id="timeslots" type="text" name="timeslots"
                placeholder="Enter timeslots"
                value="<?=$s->timeslots?>">
        </div>
        <input id="action" type="hidden" name="action" value="edit" >
        <input id="id" type="hidden" name="id" value="<?=$s->id?>" >
        <input type="submit" name="btn" value="edit" class="bigsavebtn" >
        <input type="submit" name="btn" value="DELETE" class="bigsavebtn" >
    </form>

<?php } ?>

<script>
    $(function(){
    })
</script>


<?php require "lib/footer.php" ?>
