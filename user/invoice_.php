<?php
require_once 'lib/auth.php';

require_once "../lib/app.php";

require "lib/header.php";
require "lib/menu.php";

?>

<main>
<article>
    <h1>Donload Invoice</h1>
    <p>
        Here you can download your invoice.
        If you require a special remark below your address (like tax number), enter the text into the field first:
    </p>
    <form action="invoice.php" method="post">
        <div style="padding-bottom:0.5em;">
            <label for="addline">Remark on invoice:</label>
            <input type="text" id="addline" name="addline"/>
        </div>
        <button type="submit">show invoice</button>
    </form>

</article>
</main>

<?php
require "lib/footer.php";
?>
