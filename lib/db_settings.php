<?php

// set error reporting
$DEBUG = TRUE;

if ($DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors',1);
}

// Set default timezone
date_default_timezone_set('UTC');
$dateformatstr = 'Y-m-d\ H:i:s';

/**
    Setup the registration process
**/
$baseFeeReduced = 250; // conference cost for early bookers
// $baseFeeStudents = 250; // conference cost for students bookers (we didn't do this, NOT IMPLEMENTED)
$baseFeeRegular = 300; // conference cost for late bookers
$reducedLimitDate = new DateTime("2016-07-31 23:59:59"); // the date when early booking is over
$dinnerFee = 100; // the price of the dinner, per person

// calculate if we still get early/reduced price
$now = new DateTime('NOW');
$baseFee = $now < $reducedLimitDate ? $baseFeeReduced : $baseFeeRegular;


/**
    Setup the application
**/

// name of the csv log file
$csv_db_name = "../db/register.csv";

// name of the sqlite database (mysql should work as well, thanks to PDO, but is not tested)
$db_address = 'sqlite:../db/registration.sqlite3';
$db_address_abs = 'sqlite:db/registration.sqlite3';

// the table in the database to use
$tableName = "registrationTable";

// Which fields do you want to have in the database?

$tableFields = array(       # database table columns with key => [SQL_DATATYPE, meaning]

// personal information
    'title' => ['TEXT', 'string'],
    'firstname' => ['TEXT', 'string'],
    'lastname' => ['TEXT', 'string'],
    'email' => ['TEXT', 'string'],
    'affiliation' => ['TEXT', 'string'],
    'address' => ['TEXT', 'string'],

// options
    'needInet' => ['INTEGER', 'boolean'],
    'nPersons' => ['INTEGER', 'integer'],
    'isVeggie' => ['INTEGER', 'boolean'],
    'isImpaired' => ['INTEGER', 'boolean'],

    'notes' => ['TEXT', 'string'],

    'registrationDate' => ['TEXT', 'date'],
    'lastAccessDate' => ['TEXT', 'date'],
    'accessKey' => ['INTEGER', 'hex'],

    'price' => ['INTEGER', 'integer'],
    'hasPayed' => ['INTEGER', 'boolean'],
    'amountPayed' => ['INTEGER', 'integer'],
    'payDate' => ['INTEGER', 'date'],

    'talkType' => ['INTEGER', 'choice', ['none', 'talk', 'poster']],
    'hasSubmittedAbstract' => ['INTEGER', 'boolean'],
    'abstract' => ['TEXT', 'string'],
    'abstractSubmissionDate' => ['TEXT', 'date'],
    'presentationIsChecked' => ['INTEGER', 'boolean'],  # has it been considered / looked at, and ...
    'presentationIsAccepted' => ['INTEGER', 'boolean'], # ... the desicission.
    'acceptedType' => ['INTEGER', 'choice', ['none', 'talk', 'poster']], # What type of presentation will be given (talks can be downgraded to posters, posters upgraded to talks)
    'presentationSlot' => ['TEXT', 'date'],             # which timeslot, as a date -OR-
    'posterPlace' => ['INTEGER', 'integer'],            # where to put your poster
    'presentationDuration' => ['INTEGER', 'integer'],   # duration of talk, in mins

    'proceeding' => ['BLOB', 'file'],
    'hasUploadedProceeding' => ['INTEGER', 'boolean'],
    'proceedingSubmissionDate' => ['TEXT', 'date'],
    'proceedingIsAccepted' => ['INTEGER', 'boolean']
    );

// create lookup tables
foreach ($tableFields as $key => $val) {
    if      ($val[1]=='boolean') { $boolTableFields[] = $key; }
    else if ($val[1]=='choice')  { $choiceTableFields[] = $key; }
    else if ($val[1]=='date')    { $dateTableFields[] = $key; }
    else if ($val[1]=='hex')     { $hexTableFields[] = $key; }
}


function open_db() {

    global $db_address;
    $db = NULL;

    try {
        // Create (connect to) SQLite database in file
        $db = new PDO($db_address);
        // Set errormode to exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
        echo '<br />';
        var_dump($e->getTraceAsString());

        die(1);
    }
    return $db;
}

?>
