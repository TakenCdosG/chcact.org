<?php
/*
  Plugin Name: Webinar Ignition
  Description: WebinarIgnition is a premium webinar solution that allows you to create, run and manage webinars.  Build and fully customize, professional webinar registration, confirmation, live webinar and replay pages with ease..
  Version: 1.9.8
  Author: Mark Thompson, and Dylan Jones
 */


define('WEBINARIGNITION_URL', plugins_url('/', __FILE__));
define('WEBINARIGNITION_PATH', plugin_dir_path(__FILE__));

// Activation Here:
register_activation_hook(__FILE__, 'webinarignition_installer');
include("inc/activation.php");
include("WI_Logs.php");

//$plugin_info = get_site_transient('update_plugins');
//if(version_compare($plugin_info->checked[plugin_basename(__FILE__)],'1.8.61', '<') === true) {
    global $wpdb;

    $table_name = $wpdb->prefix . "wi_logs";

    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	    $sql = "CREATE TABLE `$table_name` (
			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`campaign_id` bigint(20) unsigned DEFAULT NULL,
		    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		    `type` tinyint(4) DEFAULT NULL,
            `message` text NOT NULL,
            PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

//}



// Functions
include("inc/extra_functions.php");

// AJAX Callbacks:
include("inc/callback.php");
include("inc/callback2.php");

// Email service integration
require_once "inc/email_service_integration.php";

include("inc/autowebinar_get_dates.php");

// Image Uploader:
include("inc/image.php");

// Menu Here:
include("inc/menu.php");

// Dashboard:
include("UI/index.php");

// Page Link:
include("inc/page_link.php");

// NEW :: Shortcode Widget
include("inc/shortcode_widget.php");

// extra stuff
function wi_admin_scripts()
{
    wp_enqueue_script('jquery-ui-sortable');
}

add_action('admin_enqueue_scripts', 'wi_admin_scripts');

// Updates
require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_231('http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));
