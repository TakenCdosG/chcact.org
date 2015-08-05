<?php

// ####################################
//
//  Check If Current Is Within Range Of Email Date
//
// ####################################	
function wi_dt_check($start_date, $end_date, $date_from_db)
{

    // Convert to timestamp
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_db);

    // Check that user date is between start & end
    if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
        return "yes";
    } else {
        return "no";
    }
}

// ####################################
//
//  Build Time Stamp To Match Buffer Check
//
// ####################################	
function wi_build_time($ID, $date, $time)
{

    // ReArrange Date To Fit Format
    if (strpos($date, '-')) {
        $exDate = explode("-", $date);
    } else {
        $exDate = explode("/", $date);
    }

    $exYear = $exDate[2];
    $exMonth = $exDate[0];
    $exDay = $exDate[1];

    $newDate = $exYear . "-" . $exMonth . "-" . $exDay . " " . $time;

    return $newDate;
}

// ####################################
//
//  Send Email Notification
//
// ####################################	
function wi_send_email($ID, $num, $results)
{
    // Email not sent yet...
    // Send out email
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

    // LOOP THROUGH EMAILS HERE ::
    global $wpdb;
    $table_db_name = $wpdb->prefix . "webinarignition_leads_new";
    $leads = $wpdb->get_results("SELECT * FROM $table_db_name WHERE app_id = '$ID' ", OBJECT);

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
    // Check For Paid Link
    if ($results->paid_status == "paid") {
        // Shortcode :: LINK
        $_webinar_link = $results->webinar_permalink . "?live&" . md5($results->paid_code);
    } else {
        // Shortcode :: LINK
        $_webinar_link = $results->webinar_permalink . "?live";
    }
    $getBodyEmail = str_replace("{LINK}", '<a href="' . $_webinar_link . '">' . $_webinar_link . '</a>',
        $getBodyEmail);
    // Shortcode :: DATE
    $liveWebbyDate = explode("-", $results->webinar_date);
    $autoDate = $liveWebbyDate[2] . "-" . $liveWebbyDate[0] . "-" . $liveWebbyDate[1];


    $date_format = get_option("date_format");

    $autoDate_format = date($date_format, strtotime($autoDate));

    $months = $results->auto_translate_months;
    $days = $results->auto_translate_days;

    $autoDate_format = wi_translate_dm($months, $autoDate_format);
    $autoDate_format = wi_translate_dm($days, $autoDate_format, 'days');

    // Replace
    $getBodyEmail = str_replace("{DATE}", $autoDate_format . " @ " . wi_get_time_tz($results->webinar_start_time, $results->webinar_timezone, $results->time_format, $results->time_suffix), $getBodyEmail);

    // $getBodyEmail = str_replace("{DATE}", $results->webinar_date ." - ". $results->webinar_start_time , $getBodyEmail);
    // Loop Through Each Lead & Send ::
    $check_first = 0;
    $log_message = '';
    foreach ($leads as $leads) {
        // Shortcode :: NAME
        // $getBodyEmail = str_replace("{NAME}", $leads->name, $getBodyEmail);
        // Shortcode :: LEAD EMAIL
        //$getBodyEmail = str_replace("{EMAIL}", $leads->email, $getBodyEmail);

        // Set Email
        $log_message .= "Added {$leads->name} ({$leads->email}) to email recipient list\n";
        $mail->AddBCC($leads->email, $leads->name);
        $check_first++;
    }
    WI_Logs::add($log_message,$ID, WI_Logs::LIVE_EMAIL);

    $mail->Body = $getBodyEmail;

    // Mail Lead
    if (!$mail->Send()) {
        WI_Logs::add("ERROR:: Email could not be sent. Error message: {$mail->ErrorInfo}",$ID, WI_Logs::LIVE_EMAIL);
        // echo 'ERROR :: Email could not be sent. - Email ID :: ' . $num;
        // echo "<br><br>";
//        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    } else {
        WI_Logs::add("Mail Sent.",$ID, WI_Logs::LIVE_EMAIL);
        // Update sent status
        //$results->$getObj = "sent";
        //update_option('webinarignition_campaign_' . $ID, $results);
        // echo 'Email Sent :: ' . $leads->email;
        // echo "<br>";
        return true;
    }
}

// ####################################
//
//  Send TXT Notification
//
// ####################################	
function wi_send_txt($results)
{
    // LOOP THROUGH EMAILS HERE ::
    global $wpdb;
    $table_db_name = $wpdb->prefix . "webinarignition_leads_new";
    $leads = $wpdb->get_results("SELECT * FROM $table_db_name WHERE app_id = '{$results->id}' ", OBJECT);
    // Loop Through Each Lead & Send ::
    // Send TXT Messages
    $AccountSid = $results->twilio_id;
    $AuthToken = $results->twilio_token;
    $client = new Services_Twilio($AccountSid, $AuthToken);

    $MSG = $results->twilio_msg;
    // Shortcode {LINK}
    if ($results->paid_status == "paid") {
        $MSG = str_replace("{LINK}", $results->webinar_permalink . "?live&" . md5($results->paid_code), $MSG);
    } else {
        $MSG = str_replace("{LINK}", $results->webinar_permalink . "?live", $MSG);
    }
    $txt_sent = false;

    foreach ($leads as $leads) {
        if ($leads->phone == "undefined" || $leads->phone == "") {

        } else {
            $txt_sent = true;
            try {

                $client->account->messages->create(array(
                    'To' => trim($leads->phone),
                    'From' => $results->twilio_number,
                    'Body' => $MSG,
                ));
                WI_Logs::add("TXT Sent to {$leads->name} ({$leads->phone})",$results->id, WI_Logs::LIVE_SMS);
                //echo 'TXT Sent :: ' . $leads->phone;
                //echo "<br>";
            } catch (Exception $e) {
                // Error On Phone Number - Do Nothing
                // echo 'Error: ' . $e->getMessage();
                WI_Logs::add("Error sending TXT to {$leads->name} ({$leads->phone}): ".$e->getMessage(),$results->id, WI_Logs::LIVE_SMS);
            }
        }
    }
    if(!$txt_sent) {
        WI_Logs::add("No leads to send TXT to.",$results->id, WI_Logs::LIVE_SMS);
    }
}