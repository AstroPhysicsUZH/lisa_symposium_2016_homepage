

<script>

  //$("#price").val(10);
  
  /*
  var f = $('form');
  f.on('change keydown paste input', function(){
    alert("fired");
    $("#price").val($("#price").val()+10);
  });
  */
</script>

<h1>Registration</h1>

<p>
  The conference fee is 350.- SFr ($ 350 / 350 €) for early bookers, 
  students pay 300 SFr / $ / €.
  Early prices are valid until 2016-07-31.
  Please book your hotel in time as well!
<p>
</p>
  This fee includes:
</p>
<ul>
  <li>Attendance fee</li>
  <li>Printed proceedings</li>
  <li>Coffee breaks</li>
  <li>Conference dinner</li>
  <li>Local transportation (public transport)</li>
</ul>

<p>
  After sending this form, you will receive further instructions about payment (by banque) and your personal login link.
  Please keep it save.
  You can get a new one <a href="">here</a>.
  <br>
  For any special requests, please register anyways and contact us by email.
</p>


<form action="lib/register.php" method="post">

<table class="registration">
<thead>
  <th colspan="2">
    <h2>Personal Details</h2>
  </th>
</thead>

<tr><td>
    <label for="firstname" class="left">First name</label>
  </td><td>
    <input type="text" name="firstname" required placeholder="Enter First Name">
    <span></span>
</td></tr>

<tr><td>
    <label for="lastname" class="left">Last name</label>
  </td><td>
    <input type="text" name="lastname" required placeholder="Enter Last Name">
    <span></span>
</td></tr>

<tr><td>
    <label for="email" class="left">Email</label>
  </td><td>
    <input type="email" name="email" required placeholder="Enter Email">
    <span></span>
</td></tr>

<tr><td>
    <label for="affil" class="left">Affiliation</label>
  </td><td>
    <input type="text" name="affil" placeholder="Enter Affiliation">
    <span></span>
</td></tr>

<tr><td>
  <input id="c0" class="left" type="checkbox" name="stud" value="stud"> 
  </td><td>
  <label for="c0">Student</label>
</td></tr>

<tr><td colspan="2" style="text-align:left;">
  If you want to get the students rabatte, please send us a copy of your student ID by mail.
</td></tr>


<thead>
  <th colspan="2">
    <h2>Presentation</h2>
  </th>
</thead>

<tr><td colspan="2" style="text-align:left;">
  After submitting the registration, you will receive a link to upload your abstract for approval.
  Please prepare one page A4 as pdf only.
</td></tr>

<tr><td>
  <input id="r1" type="radio" name="talk" value="none" checked>
  </td><td>
  <label for="r1">None</label>
</td></tr>

<tr><td>
  <input id="r2" type="radio" name="talk" value="poster">
  </td><td>
  <label for="r2">Poster</label>
</td></tr>
  
<tr><td>
  <input id="r3" type="radio" name="talk" value="talk">
  </td><td>
  <label for="r3">Talk</label>
</td></tr>

<thead>
  <th colspan="2">
    <h2>Conference Dinner</h2>
  </th>
</thead>

<tr><td colspan="2" style="text-align:left;">
  The conference dinner is included in the registration fee.
  Mobility impaired people please let us know, such that we can organize transport between the train station and the restaurant.
</td></tr>


<tr><td>
  <input id="c1" class="left" type="checkbox" name="vegie" value="vegie">
  </td><td>
  <label for="c1">Vegetarian meal</label>
</td></tr>
  
<tr><td>
  <input id="c2" class="left" type="checkbox" name="2pers" value="2pers"> 
  </td><td>
  <label for="c2">Accompanying person (+100.00 SFr)</label>
</td></tr>
  
<tr><td>
  <input id="c3" class="left" type="checkbox" name="impared" value="impared"> 
  </td><td>
  <label for="c3">Mobility impaired</label>
</td></tr>


<thead>
  <th colspan="2">
    <h2>Send</h2>
  </th>
</thead>

<tr id="tr_price"><td>
    <label for="price" class="left">Total amount to pay:</label>
  </td><td>
    <input id="price" type="text" name="price" readonly placeholder="Resulting Price...">
    <span></span>
</td></tr>

<tr><td> 
  Robot test:
  </td><td>
  Please enter the <b>second number</b> in the equation:
</td></tr>

<tr><td>
  <label class="left">5 + 32 = ?</label>
  </td><td>
  <input class="right" type="number" name="robot">
</td></tr>

<tr><td>
  </td><td>
  <input type="submit" value="Submit">
</td></tr>

</table>

</form>
