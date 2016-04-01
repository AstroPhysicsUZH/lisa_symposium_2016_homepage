


<h1>Registration in progress</h1>
<p>
    You should get an email in a few minutes.
    Please <b>click the link</b> in the mail <b>to activate your registration</b>.
    You can also use this link to change your registration and/or abstract and check the payment status.
    Please note that the registration is <b>only valid, if we received your payment</b>.
</p>

<ul>
    <li>Name: <?=P($data['title'])?> <?=P($data['firstname'])?> <?=P($data['lastname'])?></li>
    <li>email: <?=P($data['email'])?></li>
    <li>access key: <b><?=P($data['accessKey'])?></b></li>
    <li>number of persons total: <?=P($data['nPersons'])?></li>
    <li>need WiFi access: <?=B($data['needInet'])?></li>
    <li>is veggie: <?=B($data['isVeggie'])?></li>
    <li>is walking impaired: <?=B($data['isImpaired'])?></li>
</ul>
