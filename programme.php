
<script src='js/fullcalendar.min.js'></script>

<h1>Programme</h1>

<ul class="submenu">
    <li><a href="#timetable">Timetable</a></li>
    <li><a href="#listoftalks">List of Talks</a></li>
    <li><a href="#listofposters">List of Posters</a></li>
    <li><a href="#conses">Contributed Sessions and Organizers</a></li>
    <li><a href="#confdin">Conference Dinner</a></li>
</ul>

<h2 id="timetable">Timetable</h2>
<p>
    Mouse over for details
</p>

<?php require "items/program.php"; ?>

<p class="small">

<!--    (will be refined as soon as details are known) -->
    (might still slightly change)
</p>

<?php require "items/list_of_talks.php"; ?>
<?php require "items/list_of_posters.php"; ?>

<? /*php require "items/plenary_speakers.php";*/ ?>
<?php require "items/show_parallelsessions.php"; ?>
<?php require "items/conference_dinner.php"; ?>
