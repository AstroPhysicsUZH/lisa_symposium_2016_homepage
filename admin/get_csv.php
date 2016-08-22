<?php

require "lib/headerphp.php";

$all_people = $db->query( "SELECT * FROM {$tableName}")->fetchAll(PDO::FETCH_OBJ);

$values = [
    'id',
    'title',
    'firstname',
    'lastname',
    'email',
    'affiliation',
    'address',
    'isPassive',
    'hasPayed',
    'amountPayed',

    'talkType',
    'presentationTitle',
    'assignedSession',
    'isPresentationAccepted',
    'acceptedType',
    'presentationSlot',
    'presentationDuration',
    'posterPlace'
];


foreach($all_people as $p) {

    foreach ($values as $key) {

        print json_encode($p->$key) . ';';
    }
    print "\n";
}

?>
