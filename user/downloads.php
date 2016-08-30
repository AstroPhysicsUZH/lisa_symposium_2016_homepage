<?php
require_once 'lib/auth.php';

require "lib/header.php";
require "lib/menu.php";

$pid = sprintf("%03u", $_SESSION['uid']);

?>

<main>
<article>
    <h1>Downloads</h1>

    <h2>Invoice</h2>
    <p>
        Here you can download your invoice.<br />
        If you require a special remark below your address (like tax number), enter the text into the field first:<br />
        If your address is incorrect, please first correct it <a href="edit.php">here</a>.
    </p>
    <form action="invoice.php" method="post">
        <div style="padding-bottom:0.5em;">
            <label for="addline">Remark on invoice:</label>
            <input type="text" id="addline" name="addline"/>
        </div>
        <button type="submit">show invoice</button>
    </form>

    <h2>Invitation Letter</h2>
    <p>
        Please contact us directly by email (reply to the registration email) to get an invitation letter.
    </p>

    <h2>Public Transportation Ticket</h2>
    <p>
        Please read the text on the ticket about where its valid and don't forget to bring an ID or passport with you.
    </p>
    <p>
        <a href="../files/zvv/<?=$pid?>.pdf">download</a>
    </p>

</article>
</main>

<?php
require "lib/footer.php";
?>
