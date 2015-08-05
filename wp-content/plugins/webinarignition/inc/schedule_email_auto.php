<?php

set_time_limit(0);
ignore_user_abort();

// ADD WORDPRESS
define('WP_USE_THEMES', false);
require('../../../../wp-blog-header.php');
status_header(200);

// Inlcude PHPMailerFunction
require_once 'PHPMailerAutoload.php';

// Include Twilio Lib
require 'Services/Twilio.php';

// CRON Setup For Sending Out Emails
$campaignID = $_GET["id"];

// Get ALL Leads
global $wpdb;
$table_db_name = $wpdb->prefix . "webinarignition_leads_evergreen";
$query = "SELECT * FROM $table_db_name WHERE app_id = '$campaignID'";
$results = $wpdb->get_results($query, OBJECT);

// Loop Through Leads
foreach ($results as $result) {
    // LOOP START ##################
    // GET DATE -------------------
    // Get Date
    // Set Timezone:
    date_default_timezone_set($result->lead_timezone);

    $date_and_time = date('Y-m-d H:i');
    $date_only = date('Y-m-d');
    $time_only = date('H:i');
    $time_only_e = explode(":", $time_only);

    $time = strtotime($time_only);
    $startTime = date("H:i", strtotime('-30 minutes', $time));
    $endTime = date("H:i", strtotime('+30 minutes', $time));

    $time_buffer = $time_only_e[1] - 10;
    $time_buffer2 = $time_only_e[1] + 10;
    $date_and_time_buffer_negative = $date_only . " " . $startTime;
    $date_and_time_buffer_plus = $date_only . " " . $endTime;
    // ####################
    // Check If Lead is Complete - Ignore
    if ($result->lead_status == "complete") {
        // IGNORE - done sequence
    } else {
        // ####################################
        //
        // Check 1 Day After
        //
        // ####################################
        if ($result->date_1_day_after_check != "sent" && ($time - strtotime($result->date_1_day_after) >= 0)) {
            // Send Out Email
            // echo "<br><br><b>EMAIL :: 1 DAY AFTER :: ". $result->email ."</b>";
            WI_Logs::add(prettifyNotificationTitle(5) . " ({$result->date_1_day_after}) triggered for {$result->name} ({$result->email}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_EMAIL);
            if(we_cron_email($_GET['id'], $result->ID, 5, $result->name, $result->email, $result->date_picked_and_live)) {
                // Update In DB
                $wpdb->update($table_db_name, array(
                    'date_1_day_after_check' => 'sent',
                    'date_after_live_check' => 'sent',
                    'date_picked_and_live_check' => 'sent',
                    'date_1_day_before_check' => 'sent',
                    'date_1_hour_before_check' => 'sent',
                    'lead_status' => 'complete'
                ), array('id' => $result->ID));
            }
            continue;
        }

        // ####################################
        //
        // Check After Live Is Over
        //
        // ####################################
        if ($result->date_after_live_check != "sent" && ($time - strtotime($result->date_after_live) >= 0)) {
            // Send Out Email
            // echo "<br><br><b>EMAIL :: 1 HOUR AFTER :: ". $result->email ."</b>";
            WI_Logs::add(prettifyNotificationTitle(4) . " ({$result->date_after_live}) triggered for {$result->name} ({$result->email}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_EMAIL);
            if(we_cron_email($_GET['id'], $result->ID, 4, $result->name, $result->email, $result->date_picked_and_live)) {
                // Update In DB
                $wpdb->update($table_db_name, array(
                    'date_after_live_check' => 'sent',
                    'date_picked_and_live_check' => 'sent',
                    'date_1_day_before_check' => 'sent',
                    'date_1_hour_before_check' => 'sent'
                ), array('id' => $result->ID));
            }
            continue;
        }

        // ####################################
        //
        // Check LIVE Webinar
        //
        // ####################################
        if ($result->date_picked_and_live_check != "sent" && ($time - strtotime($result->date_picked_and_live) >= 0)) {
            // Send Out Email
            // echo "<br><br><b>EMAIL :: EVENT LIVE :: ". $result->email ."</b>";
            WI_Logs::add(prettifyNotificationTitle(3) . " ({$result->date_picked_and_live}) triggered for {$result->name} ({$result->email}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_EMAIL);
            if(we_cron_email($_GET['id'], $result->ID, 3, $result->name, $result->email, $result->date_picked_and_live)) {
                // Update In DB
                $wpdb->update($table_db_name, array(
                    'date_picked_and_live_check' => 'sent',
                    'date_1_day_before_check' => 'sent',
                    'date_1_hour_before_check' => 'sent'
                ), array('id' => $result->ID));
            }
            continue;
        }

        // ####################################
        //
        // Check 1 Hour Before
        //
        // ####################################
        if ($result->date_1_hour_before_check != "sent" && ($time - strtotime($result->date_1_hour_before) >= 0)) {
            // Send Out Email
            // echo "<br><br><b>EMAIL :: 1 HOUR BEFORE :: ". $result->email ."</b>";
            WI_Logs::add(prettifyNotificationTitle(2) . " ({$result->date_1_hour_before}) triggered for {$result->name} ({$result->email}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_EMAIL);
            if(we_cron_email($_GET['id'], $result->ID, 2, $result->name, $result->email, $result->date_picked_and_live)) {
                // Update In DB
                $wpdb->update($table_db_name, array('date_1_hour_before_check' => 'sent', 'date_1_day_before_check' => 'sent'), array('id' => $result->ID));
            }
            if($result->phone) {
                WI_Logs::add("TXT notification ({$result->date_1_hour_before}) triggered for {$result->name} ({$result->phone}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_SMS);
                wi_send_txt($_GET['id'], $result->phone, $result->ID);
            }
            continue;
        }

        // start if loop
        // ####################################
        //
        // Check 1 Day Before
        //
        // ####################################
        if ($result->date_1_day_before_check != "sent" && ($time - strtotime($result->date_1_day_before) >= 0)) {
            // Send Out Email
            // echo "<br><br><b>EMAIL :: 1 DAY BEFORE :: ". $result->email ."</b>";
            WI_Logs::add(prettifyNotificationTitle(1) . " ({$result->date_1_day_before}) triggered for {$result->name} ({$result->email}) - chosen starting date: {$result->date_picked_and_live}", $campaignID, WI_Logs::AUTO_EMAIL);
            if(we_cron_email($_GET['id'], $result->ID, 1, $result->name, $result->email, $result->date_picked_and_live)) {
                // Update In DB
                $wpdb->update($table_db_name, array('date_1_day_before_check' => 'sent'), array('id' => $result->ID));
            }
            continue;
        }
        // end if loop
    }
}

// Send Out Emails
function we_cron_email($ID, $LEADID, $num, $NAME, $EMAIL, $DATE)
{
    // Setup Info
    $results = get_option('webinarignition_campaign_' . $ID);

    //check if notification is disabled, and halt sending it
    if ($results->{'email_notiff_' . $num} == 'off') {
        WI_Logs::add(prettifyNotification($num) . " disabled - aborting!",$ID, WI_Logs::AUTO_EMAIL);
        return;
    }

    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';
    // EMAIL SETTINGS
    $mail->IsSMTP();
    $mail->Host = $results->smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $results->smtp_user;
    $mail->Password = $results->smtp_pass;
    $mail->SMTPSecure = $results->transfer_protocol ? $results->transfer_protocol : 'tls';
    $mail->From = $results->smtp_email;
    $mail->FromName = $results->smtp_name;
    // SMTP Port
    $port = $results->smtp_port;
    if ($port == "") {
        $port = 25;
    }
    $mail->Port = $port;
    // EMAIL COPY ::
    $mail->WordWrap = 50;
    $mail->IsHTML(true);
    $getSBJ = "email_notiff_sbj_" . $num;
    $mail->Subject = $results->$getSBJ;

    // Preprocess Email w/ Shortcodes
    $getBody = "email_notiff_body_" . $num;
    $getBodyEmail = $results->$getBody;
    // Shortcode :: TITLE
    $getBodyEmail = str_replace("{TITLE}", $results->webinar_desc, $getBodyEmail);
    // Shortcode :: HOST
    $getBodyEmail = str_replace("{HOST}", $results->webinar_host, $getBodyEmail);
    // Shortcode :: LINK
    if ($results->paid_status == "paid") {
        $_webinar_link = $results->webinar_permalink . "?live&lid=" . $LEADID . "&event=OI3shBXlqsw&live=1&" . md5($results->paid_code);
    } else {
        $_webinar_link = $results->webinar_permalink . "?live&lid=" . $LEADID . "&event=OI3shBXlqsw&live=1";
    }
    $getBodyEmail = str_replace("{LINK}", '<a href="' . $_webinar_link . '">' . $_webinar_link . '</a>',
        $getBodyEmail);
    // Shortcode :: DATE
    // Translate ::
    $date_format = get_option("date_format");
    $autoDate_info = explode(" ", $DATE);
    $autoDate_format = date($date_format, strtotime($autoDate_info[0]));
    // Final Step = Translate Months
    $months = $results->auto_translate_months;
    $days = $results->auto_translate_days;

    $autoDate_format = wi_translate_dm($months, $autoDate_format);
    $autoDate_format = wi_translate_dm($days, $autoDate_format, 'days');

    // Replace
    $getBodyEmail = str_replace("{DATE}", $autoDate_format . " @ " . wi_get_time_tz($autoDate_info[1],$results->webinar_timezone, $results->time_format, $results->time_suffix) , $getBodyEmail);

    // Send Email
    $mail->AddAddress($EMAIL, $NAME);

    $mail->Body = $getBodyEmail;

    // Mail Lead
    if (!$mail->Send()) {
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        WI_Logs::add("ERROR:: Email could not be sent. Error message: {$mail->ErrorInfo}",$ID, WI_Logs::AUTO_EMAIL);
        return false;
    } else {
        // echo 'Email Sent :: ' . $EMAIL;
        // echo "<br>";
        WI_Logs::add("Mail Sent.",$ID, WI_Logs::AUTO_EMAIL);
        return true;
    }
}

// ####################################
//
//  Send TXT Notification
//
// ####################################	
function wi_send_txt($ID, $PHONE, $LEADID)
{

    // Get Results
    $results = get_option('webinarignition_campaign_' . $ID);

    $AccountSid = $results->twilio_id;
    $AuthToken = $results->twilio_token;
    $client = new Services_Twilio($AccountSid, $AuthToken);

    $MSG = $results->twilio_msg;
    // Shortcode {LINK}
    $MSG = str_replace("{LINK}", $results->webinar_permalink . "?live&lid=" . $LEADID . "&event=OI3shBXlqsw&live=1",
        $MSG);

    try {

        $client->account->messages->create(array(
            'To' => trim($PHONE),
            'From' => $results->twilio_number,
            'Body' => $MSG,
        ));
        WI_Logs::add("TXT notification Sent.", $ID, WI_Logs::AUTO_SMS);
    } catch (Exception $e) {
        // Error On Phone Number - Do Nothing
        // echo 'Error: ' . $e->getMessage();
        WI_Logs::add("Error sending TXT to {$PHONE}: ".$e->getMessage(),$ID, WI_Logs::AUTO_SMS);
    }
}