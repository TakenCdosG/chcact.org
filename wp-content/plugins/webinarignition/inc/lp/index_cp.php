<?php
// universal variables
$full_path = get_site_url();
$assets    = WEBINARIGNITION_URL . "inc/lp/";

// Get DB Info
global $wpdb;
$table_db_name = $wpdb->prefix . "webinarignition";
$ID            = $client;
$data          = $wpdb->get_results( "SELECT * FROM $table_db_name WHERE id = '$ID'", OBJECT );
foreach ( $data as $data ) {

}

$pluginName = "webinarignition";
$sitePath   = WEBINARIGNITION_URL;

// Get Results
$id      = $client;
$results = get_option( 'webinarignition_campaign_' . $id );

include_once( "fbaccess.php" );

// var_dump($results);

if ( $results->webinar_date != "AUTO" ) {

    $liveWebbyDate = explode( "-", $results->webinar_date );

    $autoDate = $liveWebbyDate[2] . "-" . $liveWebbyDate[0] . "-" . $liveWebbyDate[1];


    $date_format = get_option("date_format");
    $autoDate_format = date( $date_format, strtotime( $autoDate ) );
    // Final Step = Translate Months
    $months = $results->auto_translate_months;
    $days = $results->auto_translate_days;

    $autoDate_format = wi_translate_dm($months, $autoDate_format);
    $autoDate_format = wi_translate_dm($days, $autoDate_format, 'days');

    $autoTime        = wi_get_time_tz($results->webinar_start_time,$results->webinar_timezone, $results->time_format, $results->time_suffix);
    // instant test
    $instantTest = "";

    // For Month Icon
    $liveEventMonth     = "";
    $liveEventDateDigit = "";

    $splitAutoDate  = explode( ",", $autoDate_format );
    $splitAutoDate2 = explode( ".", $splitAutoDate[1] );

    $liveEventMonth     = $splitAutoDate2[0];
    $liveEventDateDigit = $splitAutoDate2[1];
}
?>
<!DOCTYPE html>
<html>
<head>

    <!-- META INFO -->
    <title><?php display( $results->lp_metashare_title, "Amazing Webinar" ); ?></title>
    <meta name="description"
          content="<?php display(
              $results->lp_metashare_desc,
              "Join this amazing webinar, and discover industry trade secrets!"
          ); ?>">
    <?php
    if ( $results->ty_share_image == "" ) {

    } else {
        ?>
        <meta property="og:image" content="<?php display( $results->ty_share_image, "" ); ?>"/><?php } ?>


    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="<?php echo $assets; ?>css/normalize.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $assets; ?>css/foundation.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $assets; ?>js-libs/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $assets; ?>css/main.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $assets; ?>css/cp.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>

    <link href="<?php echo $assets; ?>css/cpres.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo $assets; ?>css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $assets; ?>css/font-awesome-ie7.min.css" rel="stylesheet" type="text/css"/>

    <?php include( "css/lp_css.php" ); ?>

    <!-- CUSTOM JS -->
    <script type="text/javascript">
        <?php display($results->custom_lp_js, ""); ?>
    </script>
    <!-- CUSTOM CSS -->
    <style type="text/css">
        <?php display($results->custom_lp_css, ""); ?>
    </style>

    <?php if ( $results->wp_head_footer === 'enabled' ) {
        wp_head();
    } ?>

</head>
<body>

<!-- TOP AREA -->
<div class="topArea">
    <div class="bannerTop">
        <?php
        if ( $results->lp_banner_image == "" ) {
            // echo "NONE";
        } else {
            echo "<img src='$results->lp_banner_image' />";
        }
        ?>
    </div>
</div>

<!-- Main Area -->
<div class="mainWrapper">

<!-- HEADLINE AREA -->
<div class="headlineArea" style="display: <?php
if ( $results->lp_main_headline == "" ) {
    echo "none";
} else {
    echo "block";
}
?>;">
    <?php
    display(
        $results->lp_main_headline,
        ''
    );
    ?>
</div>

<!-- Paid webinar Checker  -->
<?php
if ( $results->paid_status == "paid" ) {
    $paid_check = "no";
} else {
    $paid_check = "yes";
}
// check if campaign ID is in the URL, if so, its the thank you url...
if ( isset( $_GET[ $results->paid_code ] ) ) {
    $paid_check = "yes";
}
?>

<!-- DATE UNDER AREA -->
<?php
if ( $results->webinar_date == "AUTO" ) {
} else {
    ?>
    <div class="cpDateUnder">
        <i class="icon-calendar"></i>
        <?php echo $autoDate_format; ?>
        <?php
        if ( $results->lp_webinar_subheadline ) {
            echo $results->lp_webinar_subheadline;
        } else {
            echo '@' . $autoTime;
        }
        ?>
    </div>
<?php } ?>

<!-- MAIN AREA -->
<div class="cpWrapper">

<div class="cpLeftSide">

<div class="optinHeadline">
    <?php
    display(
        $results->lp_optin_headline,
        '<span class="optinHeadline1" >RESERVE YOUR SPOT!</span>
					 <span class="optinHeadline2" >WEBINAR REGISTRATION</span>'
    );
    ?>
</div>

<?php
if ( $results->webinar_switch == 'closed' ) {
    echo $results->lp_optin_closed ? $results->lp_optin_closed : 'Registration is closed for this webinar.';
} else {
    ?>

    <!-- PAID WEBINAR AREA -->
    <div class="paidWebinarBlock" <?php if ( $paid_check == "no" ) {
        echo "style='display:block;'";
    } else {
        echo "style='display:none;'";
    } ?> >
        <div><?php display(
                $results->paid_headline,
                "<center><h5>Join The Webinar <Br>Order Your Spot Now!</h5></center>"
            ); ?></div>
        <?php
        if ( $results->paid_button_type != 'custom' ) {
            ?>
            <a href="<?php display( $results->paid_pay_url, "#" ); ?>" class="large button"
               style=" width:100%; background-color:<?php display(
                   $results->paid_btn_color,
                   "#5DA423"
               ); ?>; border: 1px solid rgba(0, 0, 0, 0.5) !important;"><?php display(
                    $results->paid_btn_copy,
                    "Order Webinar Now"
                ); ?></a>
        <?php
        } else {
            echo do_shortcode( $results->paid_button_custom );
        } ?>
    </div>

    <!-- OPTIN FORM -->
    <div class="optinFormArea" <?php if ( $paid_check == "no" ) {
        echo "style='display:none;'";
    } ?>>




    <?php
    // Evergreen Check
    if ( $results->webinar_date == "AUTO" ) {
        // Evergreen
        ?>
        <?php
        if ( $results->lp_schedule_type == 'fixed' ) {
            ?>
            <div class="eventDate fixed-type">
                <?php
                $dateTime = new DateTime();
                $dateTime->setTimeZone( new DateTimeZone( $results->auto_timezone_fixed ) );
                $tz_abbr    = $dateTime->format( 'T' );
                $split_date = explode( '-', $results->auto_date_fixed );
                ?>
                <img
                    src="<?php echo WEBINARIGNITION_URL . 'images/date_crystal.png'; ?>"/>
                <span style="font-size: 18px"><?php echo $results->auto_date_fixed; ?></span>

                <img
                    src="<?php echo WEBINARIGNITION_URL . 'images/clock.png'; ?>"/>
                <span style="font-size: 18px"><?php echo $results->auto_time_fixed, ' ', $tz_abbr; ?></span>

                <input type="hidden" id="webinar_start_date"
                       value="<?php echo $split_date[2], '-', $split_date[0], '-', $split_date[1]; ?>"/>
                <input type="hidden" id="webinar_start_time" value="<?php echo $results->auto_time_fixed; ?>"/>
                <input type="hidden" id="timezone_user" value="<?php echo $results->auto_timezone_fixed; ?>">
                <input type="hidden" id="today_date" value="<?php echo date( 'Y-m-d' ); ?>">
                <br clear="left"/>
            </div>
        <?php
        } elseif ( $results->lp_schedule_type == 'delayed' ) {
            ?>
            <div class="eventDate fixed-type">
                <?php
                $dateTime = new DateTime( 'now', new DateTimeZone( 'UTC' ) );
                $dateTime->modify( '+ ' . intval( $results->delayed_day_offset ) . ' days' );
                if ( $results->delayed_timezone_type !== 'user_specific' ) {
                    $dateTime->setTimezone( new DateTimeZone( $results->auto_timezone_delayed ) );
                }
                $tz_abbr = $dateTime->format( 'T' );
                ?>
                <img
                    src="<?php echo WEBINARIGNITION_URL . 'images/date_crystal.png'; ?>"/>
                <span style="font-size: 18px"><?php echo $dateTime->format( 'm-d-Y' ); ?></span>

                <img
                    src="<?php echo WEBINARIGNITION_URL . 'images/clock.png'; ?>"/>
                <span style="font-size: 18px">
                    <?php
                    echo $results->auto_time_delayed, ' ';
                    if ( $results->delayed_timezone_type !== 'user_specific' ) {
                        echo $tz_abbr;
                    } else {
                        ?>
                        <div class="user_specific_timezone_name" style="display: inline-block;font-size: 10px">
                            <?php
                            if ( $results->auto_timezone_user_specific_name ) {
                                echo $results->auto_timezone_user_specific_name;
                            } else {
                                ?>
                                YOUR<br/>TIMEZONE
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </span>

                <input type="hidden" id="webinar_start_date"
                       value="<?php echo $dateTime->format( 'Y-m-d' ); ?>"/>
                <input type="hidden" id="webinar_start_time" value="<?php echo $results->auto_time_delayed; ?>"/>
                <input type="hidden" id="timezone_user"
                       value="<?php if ( $results->delayed_timezone_type !== 'user_specific' ) {
                           echo $results->auto_timezone_delayed;
                       } ?>">
                <input type="hidden" id="today_date" value="<?php echo date( 'Y-m-d' ); ?>">
                <br clear="left"/>
            </div>
        <?php } else { ?>
            <div class="eventDate" style="border:none; margin:0px; padding:0px; padding-bottom:10px;">
                <span
                    class="autoTitle"><?php display(
                        $results->auto_translate_headline1,
                        "Choose a Date To Attend..."
                    ); ?> </span>
                <span
                    class="autoSubTitle"><?php display(
                        $results->auto_translate_subheadline1,
                        "Select a date that best suits your schedule..."
                    ); ?></span>
                <select id="webinar_start_date">
                    <option value="none">Loading Times...</option>
                </select>

                <div class="autoSep" <?php
                if ( $results->auto_today == "yes" ) {
                    echo 'style="display: none;"';
                }
                ?> ></div>
                <div id="webinarTime" <?php
                if ( $results->auto_today == "yes" ) {
                    echo 'style="display: none;"';
                }
                ?> >
                    <span
                        class="autoTitle"><?php display(
                            $results->auto_translate_headline2,
                            "What Time Is Best For You?"
                        ); ?></span>
                    <span
                        class="autoSubTitle"><?php display(
                            $results->auto_translate_subheadline2,
                            "Your Local Time Is:"
                        ); ?>
                        <span id="autoCurrentTime"></span></span>
                    <select id="webinar_start_time">
                        <?php
                        $format_string = '';
                        switch ( $results->time_format ) {
                            case '24hour':
                                $format_string = 'H:i';
                                break;
                            default:
                                $format_string = 'g:i A';
                        }
                        if ( $results->auto_time_1 !== "no" ) {
                            echo "<option value='" . $results->auto_time_1 . "'>" . date(
                                    $format_string,
                                    strtotime( "$results->auto_time_1" )
                                ) . $results->time_suffix . "</option>";
                        }
                        if ( $results->auto_time_2 !== "no" ) {
                            echo "<option value='" . $results->auto_time_2 . "'>" . date(
                                    $format_string,
                                    strtotime( "$results->auto_time_2" )
                                ) . $results->time_suffix . "</option>";
                        }
                        if ( $results->auto_time_3 !== "no" ) {
                            echo "<option value='" . $results->auto_time_3 . "'>" . date(
                                    $format_string,
                                    strtotime( "$results->auto_time_3" )
                                ) . $results->time_suffix . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" id="timezone_user" value="">
                <input type="hidden" id="today_date" value="<?php echo date( 'Y-m-d' ); ?>">
            </div>
        <?php } ?>
    <?php
    }
    ?>

    <?php
    if ( $results->webinar_date == "AUTO" ) {

    } else {

        if ( $results->lp_fb_button == "" || $results->lp_fb_button == "hide" ) {

        } else {
            ?>
            <a href="<?php
            if ( $user ) {
                echo "?confirmed";
            } else {
                echo $loginUrl;
            }
            ?>" id="optinBTNFB" class="button"><?php display( $results->lp_fb_copy, "Register With Facebook" ); ?></a>
            <div class="optOR"><?php display( $results->lp_fb_or, "OR" ); ?></div>
        <?php
        }
    }
    ?>

    <?php
    if ( ! empty( $results->ar_fields_order ) && is_array( $results->ar_fields_order ) ) {
        foreach ( $results->ar_fields_order as $_field ) {
            switch ( $_field ) {
                case 'ar_name':
                    if ( empty( $results->ar_fields_order ) || ! in_array( 'ar_lname', $results->ar_fields_order ) ) {
                        ?>
                        <input type="text" class="radius fieldRadius" id="optName"
                               placeholder="<?php display( $results->lp_optin_name, "Enter Your Full Name..." ); ?>">
                    <?php
                    } else {
                        ?>
                        <input type="text" class="radius fieldRadius optNamer" id="optFName"
                               placeholder="<?php display( $results->lp_optin_name, "Enter Your First Name..." ); ?>">
                    <?php
                    }
                    break;
                case 'ar_lname':
                    ?><input type="text" class="radius fieldRadius optNamer" id="optLName"
                             placeholder="<?php display( $results->lp_optin_lname, "Enter Your Last Name..." ); ?>" >
                    <input type="hidden" id="optName" value="#firstlast#"><?php
                    break;
                case 'ar_email':
                    ?><input type="text" class="radius fieldRadius" id="optEmail"
                             placeholder="<?php display( $results->lp_optin_email,
                                 "Enter Your Best Email..." ); ?>" ><?php
                    break;
                case 'ar_phone':
                    ?><input type="text" class="radius fieldRadius wi_phone_number" id="optPhone"
                             placeholder="<?php display(
                                 $results->lp_optin_phone,
                                 "Enter Your Phone Number..."
                             ); ?>" ><?php
                    break;
                default:
                    break;
            }
        }
    }

    if ( $results->lp_optin_button == "" || $results->lp_optin_button == "color" ) {
        ?>
        <a href="#" id="optinBTN"
           class="large button"><?php display( $results->lp_optin_btn, "Register For The Webinar" ); ?></a>
    <?php
    } else {
        ?>
        <a href="#" id="optinBTN"><img src="<?php display( $results->lp_optin_btn_image, "" ); ?>" width="327"
                                       border="0"/></a>
    <?php
    }
    ?>


    <div class="spam">
        <?php display( $results->lp_optin_spam, "* we will not spam, rent, sell, or lease your information *" ); ?>
    </div>

    </div>

<?php } ?>

</div>

<div class="cpRightSide">
    <!-- VIDEO / CTA BLOCK AREA HERE -->
    <div class="ctaArea">
        <?php
        if ( $results->lp_cta_type == "" || $results->lp_cta_type == "video" ) {
            display(
                do_shortcode( $results->lp_cta_video_code ),
                '<img src="' . $assets . 'images/novideo.png" />'
            );
        } else {
            echo "<img src='";
            display( $results->lp_cta_image, $assets . 'images/noctaimage.png' );
            echo "' height='281' width='500' />";
        }
        ?>
    </div>
</div>

<br clear="both"/>

<div class="cpUnderHeadline addedArrow">
    <?php
    display(
        $results->lp_sales_headline,
        'What You Will Learn On The Webinar...'
    );
    ?>
</div>

<div class="cpUnderCopy">


    <div class="cpCopyArea" style="width: 400px;">
        <?php
        display(
            $results->lp_sales_copy,
            '<p>Your Amazing sales copy for your webinar would show up here...</p>'
        );
        ?>
    </div>

    <div class="cpHostBlock" style="<?php
    if ( $results->lp_webinar_host_block == "hide" ) {
        echo "display:none;";
    }
    ?>">

        <div class="hostInfoPhoto">
            <img
                src="<?php display(
                    $results->lp_host_image,
                    WEBINARIGNITION_URL . "images/generic-headshot-male.jpg"
                ); ?>"/>
        </div>

        <div class="hostInfoCopy">
            <?php
            display(
                $results->lp_host_info,
                'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software...<br><br><b>- Your Name Here</b>'
            );
            ?>
        </div>

        <br clear="left"/>

    </div>

    <br clear="all"/>

</div>

</div>

</div>

<!-- BOTTOM AREA -->
<div class="bottomArea">
    <div><?php display( $results->footer_copy, "All Rights Reserved - Copyright @ " . date( 'Y' ) ); ?></div>
    <?php if ( $results->footer_branding == "show" || $results->footer_branding == "" ) { ?>
        <div style="margin-top: 15px;"><a
                href="<?php display( $results->footer_branding_url, "//webinarignition.com/" ); ?>"
                target="_blank"><b><?php display( $results->footer_branding_copy, "Powered By WebinarIgnition" ); ?></b></a>
        </div>
    <?php } ?>
</div>

<!-- AR OPTIN INTEGRATION -->
<div class="arintegration" style="display:none;">

    <iframe id="ar_submit_iframe" name="ar_submit_iframe"></iframe>
    <form action="<?php echo $results->ar_url; ?>" id="AR-INTEGRATION" method="<?php echo $results->ar_method; ?>"
          target="ar_submit_iframe">

        <?php
        if ( ! empty( $results->ar_fields_order ) && is_array( $results->ar_fields_order ) ) {
            foreach ( $results->ar_fields_order as $_field ) {
                if ( empty( $results->$_field ) ) {
                    continue;
                }
                switch ( $_field ) {
                    case 'ar_name':
                        ?><input type="text" name="<?php echo $results->ar_name; ?>" id="ar-name" value="" /><?php
                        break;
                    case 'ar_lname':
                        ?><input type="text" name="<?php echo $results->ar_lname; ?>" id="ar-lname" value="" /><?php
                        break;
                    case 'ar_email':
                        ?><input type="text" name="<?php echo $results->ar_email; ?>" id="ar-email" value="" /><?php
                        break;
                    case 'ar_phone':
                        ?><input type="text" name="<?php echo $results->ar_phone; ?>" id="ar-phone" value="" /><?php
                        break;
                    default:
                        break;
                }
            }
        }
        ?>

        <?php echo stripcslashes( $results->ar_hidden ); ?>

    </form>

</div>

<!-- JS AREA -->
<script src="<?php echo $assets; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>js/cookie.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>js-libs/js/intlTelInput.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>js/frontend.js"></script>
<script type="text/javascript" src="<?php echo $assets; ?>js/tz.js"></script>

<script type="text/javascript">
jQuery.expr[':'].parents = function (a, i, m) {
    return jQuery(a).parents(m[3]).length < 1;
};

//define some global variables
<?php
//make the thank you page url
if($results->custom_ty_url_state === 'show' && !empty($results->custom_ty_url)) {
    $thank_you_page_url = $results->custom_ty_url;
} else {
    $thank_you_page_url = $results->webinar_permalink . '?confirmed';
    if($results->paid_status === 'paid')
        {$thank_you_page_url .= '&' . urlencode($results->paid_code);}
}
?>
var thank_you_url = '<?php echo $thank_you_page_url; ?>';

$(document).ready(function () {
    // AJAX FOR WP
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

    // VIDEO FIXES:
    var wi_video_fix_w, wi_video_fix_h;
    if ($(window).width() < 480) {
        //mobile size
        wi_video_fix_w = 278;
        wi_video_fix_h = 209;
    } else {
        wi_video_fix_w = 410;
        wi_video_fix_h = 308;
    }
    $('.ctaArea').find("iframe, embed, object").height(wi_video_fix_h).width(wi_video_fix_w);

    // TRACK +1 VIEW
    $getTrackingCookie = $.cookie('we-trk-lp-<?php echo $client; ?>');

    if ($getTrackingCookie != "tracked") {
        // No Cookie Set - Track View
        $.cookie('we-trk-lp-<?php echo $client; ?>', "tracked", {expires: 30});
        var data = {action: '<?php echo $pluginName; ?>_track_view', id: "<?php echo $client; ?>", page: "lp"};
        $.post(ajaxurl, data, function (results) {
        });
    } else {
        // Already tracked...
    }
    // Track +1 Total
    var data = {action: '<?php echo $pluginName; ?>_track_view_total', id: "<?php echo $client; ?>", page: "lp"};
    $.post(ajaxurl, data, function (results) {
    });

    // Submit On Enter
    $(document).keypress(function (e) {
        if (e.which == 13) {
            $('#optinBTN').trigger('click');
        }
    });

    $('#ar_submit_iframe').load(function (event) {
        if (!$(this).data('can_load'))
            return false;
        window.location.href = thank_you_url;
    });

    // OPTIN - STORE LEAD
    $('#optinBTN').click(function () {

        // Get Info
        $fullName = $("#optName").val();

        $firstName = $("#optFName").val();
        $lastName = $("#optLName").val();

        if ($fullName == "#firstlast#") {
            // using first & last name
            $fullName = $firstName + " " + $lastName;
            $("#ar-name").val($firstName);
            $("#ar-lname").val($lastName);
        } else {
            // just full name
            $("#ar-name").val($fullName);
        }

        $email = $("#optEmail").val();

        $phone = $("#optPhone").val();

        // Set AR Form
        $("#ar-email").val($email);
        $("#ar-phone").val($phone);

        // Validation
        if ($fullName == "") {

            $("#optName").addClass("errorField");

        } else if ($email == "") {

            // Name is good
            $("#optName").removeClass("errorField");
            $("#optName").addClass("successField");
            // no email set
            $("#optEmail").addClass("errorField");

        } else {

            // Check if email is real email
            if (validateEmail($email)) {
                // alert("Good");
                $("#optEmail").addClass("successField");

                // Store Lead - Data
                <?php
                if ( $results->webinar_date == "AUTO" ) {
                            ?>
                $date = $("#webinar_start_date").val();
                $time = $("#webinar_start_time").val();
                $timezone = $("#timezone_user").val();

                var data = {
                    action: '<?php echo $pluginName; ?>_add_lead_auto',
                    id: "<?php echo $client; ?>",
                    name: "" + $fullName + "",
                    email: "" + $email + "",
                    phone: "" + $phone + "",
                    date: "" + $date + "",
                    time: "" + $time + "",
                    timezone: "" + $timezone + "",
                    ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>"
                };
                <?php } else { ?>
                var data = {
                    action: '<?php echo $pluginName; ?>_add_lead',
                    id: "<?php echo $client; ?>",
                    name: "" + $fullName + "",
                    email: "" + $email + "",
                    phone: "" + $phone + "",
                    ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>"
                };
                <?php } ?>
                // Store Lead - Post
                $.post(ajaxurl, data, function (results) {
                    // Lead Saved..

                    // Set Cookie - Signed Up
                    $.cookie('we-trk-<?php echo $client; ?>', results, {expires: 30});

                    <?php
                    if ( $results->webinar_date == "AUTO" ) {
                                ?>
                    // For Auto Webinar & redirect
                    window.location.href = "?confirmed&lid=" + results <?php if($results->paid_status=='paid') { ?> + "&<?php echo $results->paid_code; ?>"<?php } ?>;

                    <?php } else { ?>

                    // Check if AR is setup or not..
                    $arCheck = "<?php display($results->ar_url, 'none'); ?>";
                    if ($arCheck == "none") {
                        // Redirect To Thank You Page
                        window.location.href = thank_you_url;
                    } else {
                        // Submit AR Form
                        if ($("#AR-INTEGRATION").length > 0) {
                            $('#ar_submit_iframe').data('can_load', 'true');
                            HTMLFormElement.prototype.submit.call($("#AR-INTEGRATION")[0]);
                        }
                    }

                    <?php } ?>


                });

            } else {
                // alert("Bad");
                // Email isn't a real email
                $("#optName").removeClass("errorField");
                $("#optName").addClass("successField");
                $("#optEmail").addClass("errorField");
            }

        }

        return false;
    });

    // Validate Function
    function validateEmail(email) {
        var re = /\S+@\S+/;
        return re.test(email);
    }

    var user_timezone = jstz.determine_timezone().timezone.olson_tz;

    <?php
    if ( $results->webinar_date == "AUTO" && !in_array($results->lp_schedule_type,array('fixed')) ) { ?>
    if (!$("#timezone_user").val())
        $("#timezone_user").val(user_timezone);
    <?php } ?>

    <?php
    if ( $results->webinar_date == "AUTO" && !in_array($results->lp_schedule_type, array('fixed', 'delayed')) ) {
                ?>

    // Time - Current time
    var time_format = '<?php echo isset($results->time_format) ? $results->time_format : '12hour'; ?>';
    var format_string = '';
    switch (time_format) {
        case '24hour':
            format_string = 'HH:mm';
            break;
        default:
            format_string = 'h:mm A';
    }
    var local_date = moment().format(format_string);

    $("#autoCurrentTime").html(local_date + '<?php echo $results->time_suffix; ?>');

    // Get Dates
    var data = {action: 'webinarignition_auto_lp_get_dates', tz: "" + user_timezone + "", id: "<?php echo $client; ?>"};
    $.post(ajaxurl, data, function (results) {
        // Get Timezone - Today
        $dates = $.parseJSON(results);
        // Get Selected Dates
        $.each($dates, function (key, value) {
            $("#webinar_start_date option[value='none']").remove();
            $('#webinar_start_date')
                .append($('<option>', {value: key})
                    .text(value));
        });
        $('#webinar_start_date').change();
    });

    // Toggle Today & Dates
    $('#webinar_start_date').change(function () {
        if ($(this).val() == 'instant_access') {
            $("#webinarTime, .autoSep").hide();
        } else {
            var $webinar_start_time = $('#webinar_start_time');
            $webinar_start_time.find('option').prop('disabled', '');
            var date_bits = $(this).val().split('-');
            $webinar_start_time.find('option').each(function () {
                var time_bits = $(this).val().split(':');
                var test_date = new Date(parseInt(date_bits[0], 10), parseInt(date_bits[1], 10) - 1, parseInt(date_bits[2], 10), parseInt(time_bits[0], 10), parseInt(time_bits[1], 10), 0, 0);
                if (test_date.getTime() < local_date.valueOf())
                    $(this).prop('disabled', 'disabled');
            });
            $webinar_start_time.val($webinar_start_time.find('option:visible:first').val());
            $("#webinarTime, .autoSep").show();
        }

        return false;
    });

    <?php
}
?>

});
</script>

<!-- FB CONNECT AREA -->
<?php
// FB CONNECTED --
if ( isset( $_GET['code'] ) ) {
    // JUST CONNECTED - STORE LEAD - REDIRECT TO AR OR THANK YOU PAGE
    ?>
    <script type="text/javascript">
        // Add Name & Email To Optin Field & Submit It...
        $("#optName").val("<?php echo $user_info['name']; ?>");
        $("#optEmail").val("<?php echo $user_info['email']; ?>");

        $("#ar-name").val("<?php echo $user_info['name']; ?>");
        $("#ar-email").val("<?php echo $user_info['email']; ?>");

        var data = {
            action: '<?php echo $pluginName; ?>_add_lead',
            id: "<?php echo $client; ?>",
            name: "<?php echo $user_info['name']; ?>",
            email: "<?php echo $user_info['email']; ?>",
            phone: "N/A",
            ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>",
            source: "FB"
        };

        // AJAX FOR WP
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

        // Store Lead - Post
        $.post(ajaxurl, data, function (results) {
            // Lead Saved..

            // Set Cookie - Signed Up
            $.cookie('we-trk-<?php echo $client; ?>', results, {expires: 30});
            // Check if AR is setup or not..
            $arCheck = "<?php display($results->ar_url, 'none'); ?>";
            if ($arCheck == "none") {
                // Redirect To Thank You Page
                window.location.href = thank_you_url;
            } else {
                // Submit AR Form
                if ($("#AR-INTEGRATION").length > 0) {
                    $('#ar_submit_iframe').data('can_load', 'true');
                    HTMLFormElement.prototype.submit.call($("#AR-INTEGRATION")[0]);
                }
            }

        });

    </script>
<?php
}
?>

<?php if ( $results->wp_head_footer === 'enabled' ) {
    wp_footer();
} ?>

<!--Extra code-->
<?php
echo $results->footer_code;
?>
</body>
</html>
