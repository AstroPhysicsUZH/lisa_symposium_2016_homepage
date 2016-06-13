<?php
require_once 'lib/auth.php';

require_once "../lib/app.php";


require "lib/header.php";
require "lib/menu.php";

?>

<main>
<article>
    <h1>Participant data:</h1>
    <p>
        logged in as <?=$_SESSION['user']["lastname"];?>; <?=$_SESSION['user']["firstname"];?>
    </p>



    <code>
<?php
    print_r($_SESSION);
?>
    </code>
</article>
</main>

<?php
require "lib/footer.php";
?>
