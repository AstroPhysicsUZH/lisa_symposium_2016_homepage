<?php require "lib/header.php";

/**
    Allows to group presentations into types
    (like theory, experimental, ...)
**/


// $db is already open!

/*
    this table has:
    - orgas: comma separated admin names
    - timeslots: comma separated start and end dates! (multiple pairs possible)
*/

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



<h1>Categorize Presentations</h1>

<h2>Already Used Categories</h2>

<ul>
<?php
    $categories = $db->query( "SELECT DISTINCT presentationCategories FROM {$tableName}" )->fetchAll(PDO::FETCH_OBJ);
    foreach($categories as $c) {
        print "<li><code>{$c->presentationCategories}</code></li>";
    }
?>
</ul>


<h2>Presentaions</h2>

<?php
    $stmtstr = "SELECT
                    id, title, firstname, lastname, email, affiliation,
                    talkType, presentationTitle, coauthors, abstract, presentationCategories
                FROM {$tableName}
                WHERE presentationTitle<>'';";

    $presentations = $db->query( $stmtstr )->fetchAll(PDO::FETCH_OBJ);
    foreach($presentations as $p) {
?>


<form id="asscat_<?=$p->id?>"
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
    method="post">
    <h3><code>[<?=$p->id?>]</code> <?=$p->presentationTitle?></h3>
    <p>
        By: <?=$p->title?> <?=$p->firstname?> <?=$p->lastname?> (<?=$p->email?>)<br />
        <i><?=$p->affiliation?></i><br />
        <small><?=$p->coauthors?></small><br />
        <br />
        <code><?=nl2br($p->abstract) ?></code>
    </p>

    <div>
        <label for="presentationCategories" class="left">presentation Categories</label>
        <input
            type="text" name="presentationCategories"
            placeholder="cats" value="<?=$p->presentationCategories ?>">
    </div>
    <input type="hidden" name="action" value="ass_cat" >
    <input type="hidden" name="id" value="<?=$p->id?>" >
    <input type="submit" value="SAVE" class="bigsavebtn" >
</form>

<?php } ?>

<script>
    $(function(){
    })
</script>


<?php require "lib/footer.php" ?>
