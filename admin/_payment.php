
<?php
require_once "_header.php";

$not_payed_people = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed
    FROM {$tableName}
    WHERE hasPayed<>1");

$all_people = $db->query(
    "SELECT ID, title, firstname, lastname, affiliation, email, price, hasPayed, amountPayed
    FROM {$tableName}")->fetchAll(PDO::FETCH_ASSOC);



function print_table($people) {
    //print_r($people);
    print "
    <table style='width:100%;'>
        <thead class='line_bot'>
            <th>ID</th>
            <th>title</th>
            <th>name</th>
            <th>affil</th>
            <th>has to pay<br />CHF</th>
            <th>has payed?</th>
            <th>received<br />CHF</th>
            <th>edit</th>
        </thead>
        <tbody>
";

    foreach($people as $p) {
        //print_r($p);
        print("    <tr id='tr_{$p['id']}' class='line_bot'>\n");
        print("        <td class='center'>{$p['id']}</td>\n");
        print("        <td class='center'>{$p['title']}</td>\n");
        print("        <td>{$p['firstname']}<br />{$p['lastname']}</td>\n");
        print("        <td>{$p['affiliation']}</td>\n");
        print("
            <td class='center'>
                <input id='tp_{$p['id']}' name='tp_{$p['id']}'
                    class='' type='number' style='width:6em;height:2em;text-align:center;'
                    value='{$p['price']}' min='0' />
            </td>\n");
        print("
            <td class='center'>
                <input id='hp_{$p['id']}]' name='hp_{$p['id']}' class='left' type='checkbox' value='X'"
                . (( $p['hasPayed'] == 1 ) ? " checked" : "" )
                . " />
            </td>\n");
        print("
            <td class='center'>
                <input id='ap_{$p['id']}' name='ap_{$p['id']}'
                    class='' type='number' style='width:6em;height:2em;text-align:center;'
                    value='{$p['amountPayed']}' min='0' />
            </td>\n");
        print("        <td class='center'>\n");
        print("            <a href='mailto:{$p['email']}'>mail</a>\n");
        print("            <a href=''>edit</a>\n");
        print("            <a href=''>del</a>\n");
        print("        </td>");

        print("    </tr>\n");
    }

    print "
        </tbody>
    </table>
";
}


?>

<script>
gg = "";
$(function() {

    data=[];
<?php
print "/* stores [fullname, hasPayed, price, amountPayed]  and some refs */\n";
foreach($all_people as $p) {
    $hasPayed = $p['hasPayed']==1 ? 'true': 'false';
    $price = empty($p['price']) ? '0': $p['price'];
    $amountPayed = empty($p['amountPayed']) ? '0' : $p['amountPayed'];
    $fullname = "\"{$p['lastname']}; {$p['firstname']} ({$p['title']})\"";
    print "    data[{$p['id']}] = {'fn':{$fullname}, 'hp':{$hasPayed}, 'tp':{$price}, 'ap':{$amountPayed}};\n";
}
?>

    // With a custom message
    $('form').areYouSure( {'message':'Your profile details are not saved!'} );

    $.each( data, function(i, v){
        if (v==null) {return;}
        var o = $('#tr_'+i+' input');
        v.lnk = o;
        v.tr = $('#tr_'+i);
    });


    $('form').change( function() {

        $.each( data, function(i, db_value){

            if (db_value==null) {return;}

            var isDirty = false;

            db_value.lnk.each(function(ii){

                var $formObj = $(db_value.lnk[ii]);
                var n = $formObj.attr('name').substr(0,2);
                console.log("" + i + " : "+n);
                var v1,v2;

                if (typeof(db_value[n]) === "boolean") {
                    v1 = db_value[n] ? 1 : 0;
                    v2 = $formObj.is(':checked') ? 1 : 0;
                }
                else if (typeof(db_value[n]) === "number"){
                    v1 = parseInt(db_value[n]);
                    v2 = parseInt($formObj.val()) || 0;
                }

                if ( v1 != v2 ){
                    isDirty = true;
                }
                // console.log("   " + v1 + " --form: " + db_value[n] + " -- of type: " +typeof(db_value[n]));
                // console.log("   " + v2 + " --form: " + $formObj);

            })
            if (isDirty) {
                // console.log('dirty');
                db_value.tr.css({'background-color':'#faa', 'transition': 'background 0.5s linear'});
                db_value.dirty = true;
            }
            else {
                db_value.tr.css({'background-color':''});
                db_value.dirty = false;
            }
        });
    } );

});


</script>

<h1>
    Manage Payments
</h1>

<ul>
    <li><a href="payment_np.php">list of those NOT payed already</a></li>
    <li><a href="payment_all.php">list of ALL</a></li>
</ul>

<form action="_update_payment.php" method="post">
<input type="submit" value="SAVE ALL CHANGES" style="width:100%; padding: 1em; background-color:#f66; border: 1px none #f00; border-radius: 5px;">

<h2 id="notpayed">List of people that havent yet payed:</h2>

<?php
print_table($sel_people);
?>

</form>


<?php require "_footer.php"; ?>
