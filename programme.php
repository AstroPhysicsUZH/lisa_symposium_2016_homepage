
<script>
$(document).ready(function() {

<?php get_programme_json(); ?>

    $('#calendar').fullCalendar({
        weekends: false, // will hide Saturdays and Sundays
        
        height: 'auto',
        
        defaultDate: '2016-09-05',
        defaultView: 'agendaWeek',
        editable: false,
            
        header: {
            left: '',
            center: '',
            right: ''
        },
        
        views: {
            agenda: {
                scrollTime: '07:30:00',
                slotLabelFormat: 'H',
                minTime: "07:30:00",
                maxTime: "20:30:00",
                columnFormat: "ddd D"
            }
        },
        
        allDaySlot: false,
        
        /*
        googleCalendarApiKey: 'AIzaSyCPQwZ33_7ja6xo5d7M-AM-87He06wlz_c',
        events: {
            googleCalendarId: 'if3b2otfe2hog7inbn3istluck@group.calendar.google.com'
        }
        */
        
        eventSources: [evtSrcsBrks, evtSrcsCTalks, evtSrcsPTalks],
        timeFormat: 'H(:mm)',
        
    })

});
</script>


<h1>Programme</h1>

<div id='calendar'></div>

<?php include("items/programme.php"); ?>

