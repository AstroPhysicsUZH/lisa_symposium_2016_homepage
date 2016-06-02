<?php require_once "../lib/app.php"; ?>

<?php

$loggedin = FALSE;

print_r($_POST);

if (isset($_POST["op"])){

    $op = $_POST["op"];

    if ($op=="login") {
        if (!isset($_POST["email"]) || !isset($_POST["accessKey"])) {
            echo "req fields not set1";
            die(1);
        }
        $email = $_POST["email"];
        $akey = $_POST["accessKey"];

        $db = open_db($db_address);

        $stmt = $db->prepare("SELECT * FROM {$tableName} WHERE email = :email" );
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $p = $stmt->fetch(PDO::FETCH_OBJ);

        if (isset($p)) {
            #print_r($p);
            #print $p->accessKey . " | " . $akey;

            if ($p->accessKey == $akey) {
                $loggedin = TRUE;
            }
        }

    }
    else if ($op=="sendToken") {
        if (!isset($_POST["email"])) {
            echo "req fields not set2";
            die(1);
        }

    }
    else {
        echo "unsupported op";
        die(1);
    }
}


 ?>

<?php require "lib/header.php"; ?>
<?php require "lib/menu.php"; ?>

<main>
<article>

<?php if(! $loggedin) { ?>

    <p>
        Please log in using your email and access token
    </p>
    <form class="" name="login" id="login"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
          method="POST">
        <input type="hidden" name="op" value="login"/>
        <table>
            <tr>
                <td>email </td>
                <td><input type="text" name="email" value="" /></td>
            </tr>
            <tr>
                <td>access token </td>
                <td><input type="password" name="accessKey" value="" /></td>
            </tr>
        </table>
        <input type="submit" value="login" />
    </form>

    <p>
        To get a new access token send to you, please enter your email here:
    </p>
    <form class="" name="reset" id="reset"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
          method="POST">
        <input type="hidden" name="op" value="reset"/>
        <table>
            <tr>
                <td>email address </td>
                <td><input type="text" name="email" value="" /></td>
            </tr>
        </table>
        <input type="submit" value="reset access token"/>
    </form>


<?php } else { ?>


<?php } ?>


</article>
</main>



<?php require "lib/footer.php" ?>
