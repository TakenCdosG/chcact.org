<?php

// ADD WORDPRESS

define('WP_USE_THEMES', false);
require('../../../../wp-blog-header.php');
status_header(200);

$ID = $_GET['id'];

global $wpdb;
$table_db_name = $wpdb->prefix . "webinarignition_leads_new";

$results = $wpdb->get_results("SELECT * FROM $table_db_name WHERE app_id = '$ID' ", OBJECT);

// CSV Header:

header("Content-type: application/text");
header("Content-Disposition: attachment; filename=export_leads.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "Full Name, E-Mail, Sign Up, Phone, Event, Replay";
echo "\n";

foreach ($results as $results) {

    echo $results->name;
    echo ",";
    echo $results->email;
    echo ",";
    echo str_replace(',', ' -', $results->created);
    echo ",";
    echo $results->phone;
    echo ",";
    echo $results->event;
    echo ",";
    echo $results->replay;
    echo "\n";
}

//print_r($results);
?>