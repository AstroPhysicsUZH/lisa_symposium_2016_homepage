
<?php

$admin_modules = array(
    ["index.php", "Overview", ["guest", "admin", "finanz", "session_head"]],
    ["add_admin.php", "Edit Admin Users", ["admin"]],
    ["edit.php", "Edit Entries", ["admin", "helper"]],
    ["payment_np.php", "Manage Payment", ["admin", "finanz"]],
    ["payment_all.php", "Manage Payment (all)", ["admin", "finanz"]]
    #["test2.php", "testing", ["admin"]]
);

$get_acl = [];

foreach ($admin_modules as $value) {
    $site = $value[0];
    $name = $value[1];
    $acl  = $value[2];

    $get_acl[$site] = $acl;

    #print_r($acl);
    #print_r($USER->role);
    #print_r( in_array($USER->role, $acl)?"4":"0");

    if ( in_array($USER->role, $acl) ) {
        print "<a href=\"$site\"><p>$name</p></a>";
    }

}

?>
