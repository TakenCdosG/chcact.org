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

// Include Helper Functions
require 'schedule_email_live_fn.php';

// CRON Setup For Sending Out Emails
$campaignID = $_GET["id"];

// Get Results
$results = get_option('webinarignition_campaign_' . $campaignID);

// SETUP :: Core Time Settings
$TZID = wi_convert_utc_to_tzid($results->webinar_timezone);


date_default_timezone_set("$TZID");

$date_and_time = date('Y-m-d H:i');
$date_only = date('Y-m-d');
$time_only = date('H:i');
$time_only_e = explode(":", $time_only);

// SETUP :: Buffer Zone
$time = strtotime($time_only);
$startTime = date("H:i", strtotime('-30 minutes', $time));
$endTime = date("H:i", strtotime('+30 minutes', $time));
$time_buffer = $time_only_e[1] - 10;
$time_buffer2 = $time_only_e[1] + 10;
$dt_buffer_n = $date_only . " " . $startTime;
$dt_buffer_p = $date_only . " " . $endTime;

// #####################################
//
// ### Schedule Checks - Match Time/Date
//
// #####################################
//
// NOTIFICATION EMAIL #1
//
// #####################################
//
$time = time();
$webinar_utc = trim(wi_get_time_tz($time, $results->webinar_timezone, '12hour', false, true));

for ($num = 5; $num > 0; $num--) {
    $notification_date = wi_build_time($campaignID, $results->{"email_notiff_date_{$num}"}, $results->{"email_notiff_time_{$num}"});
    if ($results->{"email_notiff_" . $num} != "off" && $results->{"email_notiff_status_{$num}"} != "sent" && ($time - strtotime($notification_date)) >= 0) {
        WI_Logs::add(prettifyNotificationTitle($num) . " ($notification_date) triggered for webinar starting on {$results->webinar_date} @ {$results->webinar_start_time} ($webinar_utc)", $campaignID, WI_Logs::LIVE_EMAIL);
        if (wi_send_email($campaignID, $num, $results)) {
            for ($num; $num > 0; $num--) {
                $results->{"email_notiff_status_{$num}"} = "sent";
            }
        }
    }
}

//
// #####################################
//
// NOTIFICATION TXT
//
// #####################################
//
$notification_date = wi_build_time($campaignID, $results->email_twilio_date, $results->email_twilio_time);
if ($results->email_twilio != "off" && $results->email_twilio_status != "sent" && ($time - strtotime($notification_date)) >= 0) {

    WI_Logs::add("TXT notification ($notification_date) triggered for webinar starting on {$results->webinar_date} @ {$results->webinar_start_time} ($webinar_utc)", $campaignID, WI_Logs::LIVE_SMS);
    wi_send_txt($results);
    $results->email_twilio_status = "sent";
}

update_option('webinarignition_campaign_' . $campaignID, $results);
