<?php
/**
    defines the email message to send to the user to complete the registration
    you can use all the fields of the database, with $X['firstname']

    this should set:
    $from
    $replyto
    $subject
    $message
**/

$from    = "LISA Symposium Website <relativityUZH@gmail.com>";
$replyto = $from;
$subject = "11th LISA Symposium Registration [{$X["id"]}]";
$message = "Dear Mrs/Mr {$X["lastname"]}

Thank you very much for your registration for the 11th LISA Symposium in Zurich.
Please click on this link, to activate your registration and upload/update your abstract:

http://www.physik.uzh.ch/events/lisa2016/user.php?uid={$X['accessKey']}

Your registration fee is: {$X["price"]}.-- CHF

Please transfer it with bank transfer to:

Rechnungswesen der Universitat Zurich
LISA Symposium
8057 Zurich
IBAN-Nr.: CH12 0900 0000 3109 1810 4
Swift/BIC: POFICHBEXXX
Message: {$X["id"]} {$X["lastname"]}

If there are any questions, simply reply to this email.

Kind regards,
The local OK
"

?>
