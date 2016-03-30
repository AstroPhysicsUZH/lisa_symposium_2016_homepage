<?php
require_once "lib/db_settings.php";
?>

<script>
$( document ).ready(function(){

    // set initial value
    var baseprice = <?= $baseFee; ?>; // hey genious, this is for display only, the real value will be calculated server side anyways ;)
    var dinnerprice = <?= $dinnerFee; ?>;
    var price = baseprice + dinnerprice;
    $('#price').val(price + ".00 SFr.");

    //register update handler
    $("form :input").change(function() {
        price = baseprice + (parseInt($('#npers').val())+1) * dinnerprice;
        $("#price").val(price + ".00 SFr.");
    });

    // trigger an change for inital calculation
    $("form").change();

});
</script>


<form action="lib/register.php" method="post">
    <table class="registration">
        <thead>
            <th colspan="2">
                <h2>Personal Details</h2>
            </th>
        </thead>
        <tr>
            <td>
                <label for="title" class="left">Title</label>
            </td>
            <td>
                <input type="text" name="title" placeholder="- / PhD / Dr / Prof">
                <span></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="firstname" class="left">First name</label>
            </td>
            <td>
                <input type="text" name="firstname" required placeholder="Enter First Name">
                <span></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="lastname" class="left">Last name</label>
            </td>
            <td>
                <input type="text" name="lastname" required placeholder="Enter Last Name">
                <span></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="email" class="left">Email</label>
            </td>
            <td>
                <input type="email" name="email" required placeholder="Enter Email">
                <span></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="affiliation" class="left">Affiliation</label>
            </td>
            <td>
                <input type="text" name="affiliation" placeholder="Enter Affiliation">
                <span></span>
            </td>
        </tr>
        <tr>
            <td>
                <label for="address" class="left">Address</label>
            </td>
            <td>
                <textarea name="address"
                          style="width:250px;height:6em;"
                          placeholder="Enter your FULL ADDRESS, including your name and country, as it should be written on a letter."
                          required></textarea>
                <span></span>
            </td>
        </tr>
        <!--
        <tr>
            <td>
                <input id="c0" class="left" type="checkbox" name="stud" value="stud"> </td>
            <td>
                <label for="c0">Student</label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:left;"> If you want to get the students rabatte, please send us a copy of your student ID by mail. </td>
        </tr>
        -->
        <thead>
            <th colspan="2">
                <h2>Presentation</h2>
            </th>
        </thead>
        <tr>
            <td colspan="2" style="text-align:left;">
                After submitting the registration, you will receive a link to upload your abstract for approval. Please prepare one page A4 as pdf only.
            </td>
        </tr>
        <tr>
            <td>
                <input id="r1" type="radio" name="talkType" value="none" checked>
            </td>
            <td>
                <label for="r1">None</label>
            </td>
        </tr>
        <tr>
            <td>
                <input id="r2" type="radio" name="talkType" value="poster">
            </td>
            <td>
                <label for="r2">Poster</label>
            </td>
        </tr>
        <tr>
            <td>
                <input id="r3" type="radio" name="talkType" value="talk">
            </td>
            <td>
                <label for="r3">Talk</label>
            </td>
        </tr>
        <thead>
            <th colspan="2">
                <h2>Conference Dinner</h2>
            </th>
        </thead>
        <tr>
            <td colspan="2" style="text-align:left;">
                The conference dinner is included in the registration fee.
                Mobility impaired people please let us know, such that we can organize transport between the train station and the restaurant.
            </td>
        </tr>
        <tr>
            <td>
                <input id="npers"
                    class="left" type="number" name="nPersons"
                    value="0" style="width:3em;" min="0" max="5">
            </td>
            <td>
                <label for="nPersons">Accompanying persons (+100.00 SFr each)</label>
            </td>
        </tr>
        <tr>
            <td>
                <input id="c1" class="left" type="checkbox" name="isVeggie" value="checked">
            </td>
            <td>
                <label for="c1">Vegetarian meal</label>
            </td>
        </tr>
        <tr>
            <td>
                <input id="c3" class="left" type="checkbox" name="isImpaired" value="checked">
            </td>
            <td>
                <label for="isImpaired">Mobility impaired</label>
            </td>
        </tr>
        <thead>
            <th colspan="2">
                <h2>Send</h2>
            </th>
        </thead>
        <tr id="tr_price">
            <td>
                <label for="price" class="left">Total amount to pay:</label>
            </td>
            <td>
                <input id="price" type="text" name="price" readonly placeholder="Resulting Price...">
            </td>
        </tr>
        <tr>
            <td> Spam protection: </td>
            <td> Please enter the <b>result</b> of this equation: </td>
        </tr>
        <tr>
            <td>
                <label class="left">5 + 32 = </label>
            </td>
            <td>
                <input class="right" type="text" name="robot" required pattern="37">
                <span></span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Submit">
            </td>
        </tr>
    </table>
</form>
