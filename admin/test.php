<?php

  // Set default timezone
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set('UTC');
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:../db/registration.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);

    /**************************************
    * Create tables                       *
    **************************************/

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS registrationTable (
                    id INTEGER PRIMARY KEY,
                    title TEXT,
                    firstname TEXT,
                    lastname TEXT,
                    email TEXT,
                    affiliation TEXT,
                    talkType INTEGER,
                    nPersons INTEGER,
                    isVeggie INTEGER,
                    isImpaired INTEGER,

                    registrationDate TEXT,
                    lastAccessDate TEXT,
                    accessKey INTEGER,

                    hasPayed INTEGER,
                    payDate TEXT,

                    hasSubmittedAbstract INTEGER,
                    abstractSubmissionDate TEXT,
                    presentationIsAccepted INTEGER,
                    acceptedType INTEGER,
                    presentationSlot TEXT,

                    hasUploadedProceeding INTEGER,
                    proceedingSubmissionDate TEXT,
                    proceedingIsAccepted INTEGER

                )");


    // check if email already in table
    $email = 'phil@harmonie.net';
    /*
    //$stmt = $file_db->prepare("SELECT id,email FROM registrationTable WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */
    $stmt = $file_db->prepare("SELECT COUNT(*) FROM registrationTable WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $res = $stmt->execute();
    $nEntries = $stmt->fetchColumn();

    echo "found that with my query<br />\n";
    print_r();
    echo "<hr /><br />\n";


    /**************************************
    * Set initial data                    *
    **************************************/

    // Array with some test data to insert to database
    $messages = array(
                    array(
                        'title' => 'Dr',
                        'firstname' => 'Phil',
                        'lastname' => 'Harmonie',
                        'email' => 'phil@harmonie.net',
                        'affiliation' => 'orchestra',
                        'talkType' => 2,
                        'nPersons' => 2,
                        'isVeggie' => FALSE,
                        'isImpaired' => TRUE,

                        'registrationDate' => '2016-01-31 23:59:59.999',
                        'lastAccessDate' => NULL,
                        'accessKey' => NULL,

                        'hasPayed' => FALSE,
                        'payDate' => NULL,

                        'hasSubmittedAbstract' => NULL,
                        'abstractSubmissionDate' => NULL,
                        'presentationIsAccepted' => NULL,
                        'acceptedType' => NULL,
                        'presentationSlot' => NULL,

                        'hasUploadedProceeding' => NULL,
                        'proceedingSubmissionDate' => NULL,
                        'proceedingIsAccepted' => NULL

                    )/*,
                    array(
                        'title' => '',
                        'firstname' => '',
                        'lastname' => '',
                        'email' => '',
                        'affiliation' => '',
                        'talkType' => '',
                        'nPersons' => '',
                        'talkType' => '',
                        'isVeggie' => '',
                        'isImpaired' => '',

                        'registrationDate' => '',
                        'lastAccessDate' => '',
                        'accessKey' => '',

                        'hasPayed' => '',
                        'payDate' => '',

                        'hasSubmittedAbstract' => '',
                        'abstractSubmissionDate' => '',
                        'presentationIsAccepted' => '',
                        'acceptedType' => '',
                        'presentationSlot' => '',

                        'hasUploadedProceeding' => '',
                        'proceedingSubmissionDate' => '',
                        'proceedingIsAccepted' => ''
                    ),*/
                );
/*
title ,
firstname ,
lastname ,
email ,
affiliation ,
talkType ,
nPersons ,
isVeggie ,
isImpaired ,

registrationDate ,
lastAccessDate ,
accessKey ,

hasPayed ,
payDate ,

hasSubmittedAbstract ,
abstractSubmissionDate ,
presentationIsAccepted ,
acceptedType ,
presentationSlot ,

hasUploadedProceeding ,
proceedingSubmissionDate ,
proceedingIsAccepted ,
*/
/*
title, firstname, lastname, email, affiliation, talkType, nPersons,
isVeggie, isImpaired,
registrationDate, lastAccessDate, accessKey,

hasPayed, payDate,

hasSubmittedAbstract, abstractSubmissionDate, presentationIsAccepted,
acceptedType, presentationSlot,

hasUploadedProceeding, proceedingSubmissionDate, proceedingIsAccepted
*/
/*
:title, :firstname, :lastname, :email, :affiliation, :talkType, :nPersons,
:isVeggie, :isImpaired,
:registrationDate, :lastAccessDate, :accessKey,

:hasPayed, :payDate,

:hasSubmittedAbstract, :abstractSubmissionDate, :presentationIsAccepted,
:acceptedType, :presentationSlot,

:hasUploadedProceeding, :proceedingSubmissionDate, :proceedingIsAccepted
*/
/*
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':affiliation', $affiliation);
    $stmt->bindParam(':talkType', $talkType);
    $stmt->bindParam(':nPersons', $nPersons);
    $stmt->bindParam(':isVeggie', $isVeggie);
    $stmt->bindParam(':isImpaired', $isImpaired);

    $stmt->bindParam(':registrationDate', $registrationDate);
    $stmt->bindParam(':lastAccessDate', $lastAccessDate);
    $stmt->bindParam(':accessKey', $accessKey);

    $stmt->bindParam(':hasPayed', $hasPayed);
    $stmt->bindParam(':payDate', $payDate);

    $stmt->bindParam(':hasSubmittedAbstract', $hasSubmittedAbstract);
    $stmt->bindParam(':abstractSubmissionDate', $abstractSubmissionDate);
    $stmt->bindParam(':presentationIsAccepted', $presentationIsAccepted);
    $stmt->bindParam(':acceptedType', $acceptedType);
    $stmt->bindParam(':presentationSlot', $presentationSlot);

    $stmt->bindParam(':hasUploadedProceeding', $hasUploadedProceeding);
    $stmt->bindParam(':proceedingSubmissionDate', $proceedingSubmissionDate);
    $stmt->bindParam(':proceedingIsAccepted ', $proceedingIsAccepted )
*/


/*
$title = $m['title']
$firstname = $m['firstname']
$lastname = $m['lastname']
$email = $m['email']
$affiliation = $m['affiliation']
$talkType = $m['talkType']
$nPersons = $m['nPersons']
$isVeggie = $m['isVeggie']
$isImpaired = $m['isImpaired']

$registrationDate = $m['registrationDate']
$lastAccessDate = $m['lastAccessDate']
$accessKey = $m['accessKey']

$hasPayed = $m['hasPayed']
$payDate = $m['payDate']

$hasSubmittedAbstract = $m['hasSubmittedAbstract']
$abstractSubmissionDate = $m['abstractSubmissionDate']
$presentationIsAccepted = $m['presentationIsAccepted']
$acceptedType = $m['acceptedType']
$presentationSlot = $m['presentationSlot']

$hasUploadedProceeding = $m['hasUploadedProceeding']
$proceedingSubmissionDate = $m['proceedingSubmissionDate']
$proceedingIsAccepted = $m['proceedingIsAccepted']
*/


    /**************************************
    * Play with databases and tables      *
    **************************************/

    // Prepare INSERT statement to SQLite3 file db
/*
    $insert = "INSERT INTO registrationTable (
        title, firstname, lastname, email, affiliation, talkType, nPersons,
        isVeggie, isImpaired,
        registrationDate, lastAccessDate, accessKey,

        hasPayed, payDate,

        hasSubmittedAbstract, abstractSubmissionDate, presentationIsAccepted,
        acceptedType, presentationSlot,

        hasUploadedProceeding, proceedingSubmissionDate, proceedingIsAccepted
    )
                VALUES (
        :title, :firstname, :lastname, :email, :affiliation, :talkType, :nPersons,
        :isVeggie, :isImpaired,
        :registrationDate, :lastAccessDate, :accessKey

        :hasPayed, :payDate,

        :hasSubmittedAbstract, :abstractSubmissionDate, :presentationIsAccepted,
        :acceptedType, :presentationSlot,

        :hasUploadedProceeding, :proceedingSubmissionDate, :proceedingIsAccepted
    )";
*/

    $insert = "INSERT INTO registrationTable (
        title, firstname, lastname, email, affiliation, talkType, nPersons,
        isVeggie, isImpaired,
        registrationDate, lastAccessDate, accessKey,

        hasPayed, payDate,

        hasSubmittedAbstract, abstractSubmissionDate, presentationIsAccepted,
        acceptedType, presentationSlot,

        hasUploadedProceeding, proceedingSubmissionDate, proceedingIsAccepted

    )
                VALUES (
        :title, :firstname, :lastname, :email, :affiliation, :talkType, :nPersons,
        :isVeggie, :isImpaired,
        :registrationDate, :lastAccessDate, :accessKey,

        :hasPayed, :payDate,

        :hasSubmittedAbstract, :abstractSubmissionDate, :presentationIsAccepted,
        :acceptedType, :presentationSlot,

        :hasUploadedProceeding, :proceedingSubmissionDate, :proceedingIsAccepted

    )";


    $stmt = $file_db->prepare($insert);

    // Bind parameters to statement variables
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':affiliation', $affiliation);
    $stmt->bindParam(':talkType', $talkType);
    $stmt->bindParam(':nPersons', $nPersons);
    $stmt->bindParam(':isVeggie', $isVeggie);
    $stmt->bindParam(':isImpaired', $isImpaired);

    $stmt->bindParam(':registrationDate', $registrationDate);
    $stmt->bindParam(':lastAccessDate', $lastAccessDate);
    $stmt->bindParam(':accessKey', $accessKey);

    $stmt->bindParam(':hasPayed', $hasPayed);
    $stmt->bindParam(':payDate', $payDate);

    $stmt->bindParam(':hasSubmittedAbstract', $hasSubmittedAbstract);
    $stmt->bindParam(':abstractSubmissionDate', $abstractSubmissionDate);
    $stmt->bindParam(':presentationIsAccepted', $presentationIsAccepted);
    $stmt->bindParam(':acceptedType', $acceptedType);
    $stmt->bindParam(':presentationSlot', $presentationSlot);

    $stmt->bindParam(':hasUploadedProceeding', $hasUploadedProceeding);
    $stmt->bindParam(':proceedingSubmissionDate', $proceedingSubmissionDate);
    $stmt->bindParam(':proceedingIsAccepted', $proceedingIsAccepted );


    // Loop thru all messages and execute prepared insert statement
    foreach ($messages as $m) {
      // Set values to bound variables
      $title = $m['title'];
      $firstname = $m['firstname'];
      $lastname = $m['lastname'];
      $email = $m['email'];
      $affiliation = $m['affiliation'];
      $talkType = $m['talkType'];
      $nPersons = $m['nPersons'];
      $isVeggie = $m['isVeggie'];
      $isImpaired = $m['isImpaired'];

      $registrationDate = $m['registrationDate'];
      $lastAccessDate = $m['lastAccessDate'];
      $accessKey = $m['accessKey'];

      $hasPayed = $m['hasPayed'];
      $payDate = $m['payDate'];

      $hasSubmittedAbstract = $m['hasSubmittedAbstract'];
      $abstractSubmissionDate = $m['abstractSubmissionDate'];
      $presentationIsAccepted = $m['presentationIsAccepted'];
      $acceptedType = $m['acceptedType'];
      $presentationSlot = $m['presentationSlot'];

      $hasUploadedProceeding = $m['hasUploadedProceeding'];
      $proceedingSubmissionDate = $m['proceedingSubmissionDate'];
      $proceedingIsAccepted = $m['proceedingIsAccepted'];

      // Execute statement
      $stmt->execute();
    }


    // Select all data from memory db messages table
    $result = $file_db->query('SELECT * FROM registrationTable', PDO::FETCH_ASSOC);

    foreach($result as $row) {
        echo "<br /><hr />\n<!-- --------------------- -->\n<br />\n";
        foreach($row as $key => $val) {
            echo $val . " ($key); ";
        }
        echo "<br />\n";
    }


    /**************************************
    * Drop tables                         *
    **************************************/

    // Drop table messages from file db
    //$file_db->exec("DROP TABLE messages");


    /**************************************
    * Close db connections                *
    **************************************/

    // Close file db connection
    $file_db = null;
    // Close memory db connection
    $memory_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
    echo '<br />';
    var_dump($e->getTraceAsString());
  }
?>
