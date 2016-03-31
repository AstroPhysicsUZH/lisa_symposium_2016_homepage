<?php

/**
    we send post requests for registration to here.
    will write the data to the db and notify admins by email
**/

require_once "../lib/db_settings.php";

require_once 'parsecsv.lib.php';
$filename = "../data/register.csv";

$rtest = intval($_POST['robot']);
$rtest = 37;
// print_r($_POST);

if ($rtest != 37) {
    echo "<h1 style='text-align:center;'>You did not pass the robot test.<br> Please just enter the number 37..</h1>";
    var_dump($_POST);
    die(1);
}

if (! isset($_POST['email'])) {
    echo "<h1 style='text-align:center;'>No email in POST<br>However this happend...</h1>";
    var_dump($_POST);
    die(1);
}


// init to default values
// because checkboxes only give a value if checked..
// all others could be set to null
$vals = [
    "title" => "",
    "lastname" => "",
    "firstname" => "",
    "email" => "",
    "affiliation" => "",
    "nPersons" => 1,
    "needInet" => FALSE,
    "isVeggie" => FALSE,
    "isImpaired" => FALSE,

    "hasPayed" => FALSE,

    "talkType" => 0,
    'hasSubmittedAbstract' => NULL,
];

// read post fields
foreach ($tableFields as $key => $arr) {
    $sqltype = $arr[0];
    $type = $arr[1];
    $choices = (isset($arr[2])) ? $arr[2] : NULL ;

    if (isset($_POST[$key])) {
        $x = $_POST[$key];
        if ($type == 'string') {
            $vals[$key] = strval($x);
        }
        elseif ($type == "integer") {
            $vals[$key] = intval($x);
        }
        elseif ($type == "boolean") {
            $vals[$key] = boolval($x);
        }
        elseif ($type == "choice") {
            $vals[$key] = intval(array_search($x, $choices, TRUE)); # if not found this returns False, which gets casted to 0, the first and default choice
        }
        elseif ($type == "date") {
            $dt = new DateTime($x);
            $vals[$key] = $dt->format($dateformatstr);
        }
    }
    else { # if no default value is set, set to null
        if (!isset($vals[$key])) {
            $vals[$key] = NULL;
        }
    }
}

// fill in other fields

$vals["nPersons"] += 1; # convert from nAdditionalPersons to nPersons
$vals["notes"] = $now->format($dateformatstr) . "\tregistered\n";
$vals["price"] = $baseFee + $dinnerFee * $vals["nPersons"];
$vals["registrationDate"] = $now->format($dateformatstr);
#$vals["lastAccessDate"] = $now->format($dateformatstr);
$vals["hasPayed"] = FALSE;


try {
    // Create (connect to) SQLite database (creates if not exists)
    $db = open_db();

    $findEmail = $vals['email'];
    $stmt = $db->prepare("SELECT COUNT(*) FROM {$tableName} WHERE email = :email");
    $res = $stmt->execute(array(':email'=>$findEmail));
    $nEntries = $stmt->fetchColumn();

    if ($nEntries > 0) {
        echo "<h1 style='text-align:center;'>This email address is already registered</h1>\n";
        var_dump($_POST);
        die(1);
    }

    # generate unique access key
    $repeat = TRUE;
    while ($repeat) {
        $akey = bin2hex(openssl_random_pseudo_bytes(4)); # 4 bytes makes 8 = 2x4 hex digits
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$tableName} WHERE accessKey = :akey");
        $res = $stmt->execute(array(':akey'=>$akey));
        if ( $stmt->fetchColumn() == 0 ) { # if no entries found, we got a valid one
            $vals["accessKey"] = $akey;
            $repeat = FALSE;
        }
    }

    $insert  = "INSERT INTO {$tableName} (";
    $insert .= implode(", ", array_keys($tableFields));
    $insert .= ") VALUES ( ";
    $insert .= implode(", ", array_map(function($value) { return ':'.$value; }, array_keys($tableFields)));
    $insert .= ")";

    $stmt = $db->prepare($insert);
    $stmt->execute($vals);
    $lastId = $db->lastInsertId();

    // Close file db connection
    $db = null;
}
catch(PDOException $e) {
    // Print PDOException message
    echo "<h1 style='text-align:center;'>
        Something went wrong with the database..
        </h1>\n";
    echo $e->getMessage();
    echo '<br>';
    var_dump($e->getTraceAsString());
    die(1);
}

$vals['_ID'] = $lastId;


$csv = new parseCSV();
$csv->sort_by = 'email';
$csv->parse($filename);
$csv->data[$vals['email']] = $vals;
$csv->save();
#print_r($csv->data);


$from = "LISA Symposium Website <relativityUZH@gmail.com>";
$to1 = "rafik@physik.uzh.ch";
$to2 = "relativityUZH@gmail.com";
$subj = "[LISA] registration";
$msg  = "this is just an automated backup mail in case of database corruption\n\n";
$msg .= json_encode($vals);

$headers  = 'From: ' . $from . "\r\n";
$headers .= "Reply-To:" . $from . "\r\n" .
$headers .= "X-Mailer: PHP/" . phpversion();

mail($to1, $subj, $msg, $headers);
mail($to2, $subj, $msg, $headers);

$subjX = "11th LISA Symposium Registration";
$msgX  = "Dear Mrs/Mr {$vals["lastname"]}

Thank you very much for your registration for the 11th LISA Symposium in Zurich.
Please click on this link, to activate your registration and upload/update your abstract:
http://www.physik.uzh.ch/events/lisa2016/user.php?uid={$akey}

Your registration fee is: {$vals["price"]}.-- CHF

Please transfer it with banque transfer to:

Rechnungswesen der Universitaet Zuerich
LISA Symposium
8057 Zuerich
IBAN-Nr.: CH12 0900 0000 3109 1810 4
Swift/BIC: POFICHBEXXX

Kind regards,
The local OK";

mail($vals['email'], $subjX, $msgX, $headers);

$url = "../index.php?page=msgs&mid=reg_suc&lid={$lastId}&akey={$akey}";
header('Location: ' . $url);
die();

?>
