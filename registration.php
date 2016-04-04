
<h1>Registration</h1>

<p>
    The <b>reduced</b> conference fee for early bookers is CHF <?=$baseFeeReduced+$dinnerFee;?>.&mdash; until <?=$reducedLimitDate->format($date_fstr);?>.
    <br />
    Normal fee must be paid of CHF <?=$baseFeeRegular+$dinnerFee;?>.&mdash; until <?=$registrationLimitDate->format($date_fstr);?> (registration closes).
</p>
<p>
    Please remember to book your hotel in time as well!
</p>

<p>
    The fee includes:
</p>
<ul>
    <li>Attendance fee</li>
    <li>Printed proceedings</li>
    <li>Coffee breaks</li>
    <li>Conference dinner</li>
    <li>Local transportation (24h public transport, city zone, Mon - Fri; except airport transfer)</li>
</ul>

<p>
    After sending this form, you will receive further instructions about payment (by bank) and your personal login link.
    Please keep it save.
    (The login area will be available in a few days time.)
<!--
    You can get a new one <a href="">here</a>.
-->
    <br>
    For any special requests, please register anyways and contact us by email by replaying to the registration email or by writing an email to <a href="mailto:relativityuzh@gmail.com">relativityUZH@gmail.com</a>.
</p>

<?php require "items/registration_form.php"; ?>
