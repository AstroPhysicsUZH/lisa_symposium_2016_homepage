<?php
require_once 'lib/auth.php';


require "lib/header.php";
require "lib/menu.php";

?>

<main>
<article>
    <h1>Participant's Area</h1>
    <p>
        logged in as <?=$P["title"];?> <?=$P["lastname"];?>; <?=$P["firstname"];?>
    </p>

    <h2>Contact Data</h2>
    <p>
        We use this address to send you letters:<br />
        <span class="small">
            (if you forgot to add your name in the address field, please do so now <a href="edit.php">here</a> or by clicking the address)
        </span>
    </p>
    <a href="edit.php" class="nolink">
        <code>
            <?=nl2br($P['address'])?>
        </code>
    </a>

    <h2>Payment status:</h2>
<?php
    if ($P['hasPayed']) {
        echo '
        <p class="notice centered">
            We received your payment. Thank you very much.<br />
            Get your invoice on the left hand side
        </p>';
    }
    else {
        echo '
        <p class="warning centered">
            We haven\'t received your payment yet<br />
            <span class="small">But it might take several days time for the transfer to actually reach us, so please be patient or contact us by email.</span>
        </p>';
    }

    if ($P['paymentNotes']) {
        echo "
        <p class=\"notice centered\"><span class='small'>
            <b>Notes from the organizer:</b><br />
            <span>
                {$P['paymentNotes']}
            </span></span>
        </p>";
    }
?>
    <ul>
        <li>Amount to pay: <?=$P['price']?></li>
        <li>Amount received: <?=$P['amountPayed']?></li>
    </ul>


<!--  <code>
<?php
    print_r($_SESSION);
?>
    </code>-->
</article>
</main>

<?php
require "lib/footer.php";
?>
