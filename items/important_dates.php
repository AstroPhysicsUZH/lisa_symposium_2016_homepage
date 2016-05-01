
<ul>
    <li>
        <span class='small datetime'>
            <?=$abstractSubmissionDate->format($date_fstr)?>
        </span>
        Deadline for submissions (abstracts / posters)
    </li>
    <li>
        <span class='small datetime'>
            <?=$reducedLimitDate->format($datetime_fstr)?>
        </span>
        Deadline for early registration
    </li>
    <li>
        <span class='small datetime'>
            <?=$registrationLimitDate->format($datetime_fstr)?>
        </span>
        Registration closes
    </li>
    <li>
        <span class='small datetime'>
            <?=$conferenceDinnerDate->format($datetime_fstr)?>
        </span>
        Conference dinner
    </li>
<!--
    <li><span class='date'>2016-09-05 08:00</span> Registration Opens</li>
    <li><span class='date'>2016-09-05 09:00</span> Opening Talk</li>
    <li><span class='date'>2016-09-05 15:00</span> Group Picture</li>
    <li><span class='date'>2016-09-09 15:00</span> Closing Ceremony</li>
-->
</ul>
