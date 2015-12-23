<?php

# security check..
$gh_ips = array('171.149.246.236', '95.92.138.4', '212.51.156.200');
if (in_array($_SERVER['REMOTE_ADDR'], $gh_ips) === false) {
    header('Status: 403 Your IP is not on our list; bugger off', true, 403);
    #mail('root', 'Unfuddle hook error: bad ip', $_SERVER['REMOTE_ADDR']);
    die(1);
}

$outp = array();

#$command = "pwd && ls && git reset --hard HEAD && git pull origin master";
$command = "git status; git reset --hard HEAD; git pull origin master; git status";

$output = exec($command . " 2>&1", $outp);

echo "<h3>Output</h1>\n";
echo "<pre>\n";
echo $output . "\n";

echo "\n\n<hr>\n\n";

foreach ($outp as $line) {
    echo $line . "\n";
}
#var_dump($outp);


/*
$BRANCH = $_GET['branch'];
if (!empty($BRANCH)) {
    $output = shell_exec("cd /srv/www/git-repo/; git pull origin {$BRANCH};");
    echo "<pre>$output</pre>";
}
*/

echo "\n\n<hr>\n\n";

die("done\n" . date(DATE_ATOM));


?>