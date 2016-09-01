<?php

require "lib/headerphp.php";

$stmtstr = "SELECT
                id, title, firstname, lastname, email, affiliation,
                talkType, presentationTitle, coauthors, abstract, presentationCategories,
                assignedSession, isPresentationAccepted, acceptedType,
                presentationSlot, presentationDuration
            FROM {$tableName}
            WHERE talkType>0
            ORDER BY id ASC;" ;

$data = $db->query( $stmtstr )->fetchAll(PDO::FETCH_OBJ);

header('Content-Type: application/json; charset=UTF-8');
# header('Content-Disposition: attachment; filename="participants.csv";');

print json_encode($data);

?>
