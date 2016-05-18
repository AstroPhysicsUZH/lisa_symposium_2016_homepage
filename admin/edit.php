<?php require "lib/header.php"; ?>

<?php

if (array_key_exists("action", $_POST)) {

    if ($_POST["action"]=="save") {

    }
    else if ($_POST["action"]=="save") {

    }
}

?>



<h1>Edit Entries</h1>
<ul class="menu">
    <li><a href='#entry'>entry</a></li>
    <li><a href='#overview'>overview</a></li>
</ul>

<h2 id='entry'>Entry</h2>

<?php
if (array_key_exists('id', $_GET)):
    $ID = $_GET['id'];

    $stmt = $db->prepare("SELECT * FROM {$tableName} WHERE ID = :id" );
    $stmt->bindParam(":id", $ID);
    $stmt->execute();
    $p = $stmt->fetch(PDO::FETCH_OBJ);
?>

<form action="" method="post">
    <table class="edit">
        <thead>
            <th colspan="2">
                <b>Personal Details</b>
            </th>
        </thead>
        <tr>
            <td><label for="title" class="left">Title</label></td>
            <td>
                <input id="title" type="text" name="title" placeholder="- / PhD / Dr / Prof" value="<?=$p->title?>">
            </td>
        </tr>
        <tr>
            <td><label for="firstname" class="left">First name</label></td>
            <td>
                <input id="firstname" type="text" name="firstname" required placeholder="Enter First Name" value="<?=$p->firstname?>">
            </td>
        </tr>
        <tr>
            <td><label for="lastname" class="left">Last name</label></td>
            <td>
                <input id="lastname" type="text" name="lastname" required placeholder="Enter Last Name"  value="<?=$p->lastname?>">
            </td>
        </tr>
        <tr>
            <td><label for="email" class="left">Email</label></td>
            <td>
                <input type="email" name="email" required placeholder="Enter Email"  value="<?=$p->email?>">
            </td>
        </tr>
        <tr>
            <td><label for="affiliation" class="left">Affiliation</label></td>
            <td>
                <input id="affiliation" type="text" name="affiliation" placeholder="Enter Affiliation" value="<?=$p->affiliation?>">
            </td>
        </tr>
        <tr>
            <td><label for="address" class="left">Full Address</label></td>
            <td>
                <textarea name="address"
                          placeholder="Enter your FULL ADDRESS, including your FULL NAME and country, as it should be written on a letter."
                          required><?=$p->address?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input
                    id="needInet" class="left" type="checkbox"
                    name="needInet" value="X"
                    <?= $p->needInet ? "checked" : "" ?> >
            </td>
            <td><label for="needInet">Need WIFI</label></td>
        </tr>

        <tr>
            <td><label for="talkType" class="left">Talk Type</label></td>
            <td>
                <input id="talkType"
                    type="text" name="talkType" placeholder="talktype 0:none, 1:talk, 2:poster"
                    value="<?=$p->talkType?>">
            </td>
        </tr>

        <tr>
            <td><label for="nPersons">Acc persons</label></td>
            <td>
                <input id="nPersons"
                    type="number" name="nPersons"
                    value="<?=$p->nPersons?>">
            </td>
        </tr>
        <tr>
            <td>
                <input id="c1" class="left" type="checkbox"
                    name="isVeggie" value="checked"
                    <?= $p->isVeggie ? "checked" : "" ?> >
            </td>
            <td><label for="c1">Vegetarian meal</label></td>
        </tr>
        <tr>
            <td>
                <input id="isImpaired"
                    class="left" type="checkbox"
                    name="isImpaired" value="checked"
                    <?= $p->isImpaired ? "checked" : "" ?> >
            </td>
            <td><label for="isImpaired">Mobility impaired</label></td>
        </tr>


        <tr>

        </tr>
    </table>
    <input type="submit" value="SAVE CHANGES" class="bigsavebtn">
</form>

<?php endif; ?>

<h2 id='overview'>Overview</h2>
<p>
    Click on the entry to edit
</p>

<table id="tab_all" style='width:100%;'>
    <thead class='line_bot'>
        <th>ID</th>
        <th></th>
        <th>name</th>
        <th></th>
        <th>affil</th>
    </thead>
    <tbody>

<?php
$all_people = $db->query( "SELECT * FROM {$tableName}")->fetchAll(PDO::FETCH_OBJ);

foreach($all_people as $p): ?>
        <tr id="tr<?=$p->id;?>" class='line_bot' data-id="<?=$p->id;?>">
            <td class='center'><?=$p->id;?></td>
            <td class='right'><?=$p->title;?></td>
            <td><?=$p->lastname;?></td>
            <td><?=$p->firstname;?></td>
            <td><?=$p->affiliation;?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>

<script>
    $(function(){
        $('#tab_all tr').click(function(){
            $this = $(this);
            console.log("clicked on row: " + $this.data('id'));
            window.location = '?id=' + $this.data('id');
        });
    })
</script>


<?php require "lib/footer.php" ?>
