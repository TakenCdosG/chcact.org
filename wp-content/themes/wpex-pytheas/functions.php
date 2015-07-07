<?php
/**
 * Pytheas functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */

/*--------------------------------------*/
/* Akendos Custom functions and definitions */
/*--------------------------------------*/
require_once( get_template_directory() .'/assets/functions/functions.php');

/*--------------------------------------*/
/* Define Constants
/*--------------------------------------*/
define( 'WPEX_JS_DIR', get_template_directory_uri().'/js' );
define( 'WPEX_CSS_DIR', get_template_directory_uri().'/css' );


/*--------------------------------------*/
/* Globals
/*--------------------------------------*/
if ( ! isset( $content_width ) ) $content_width = 650;
require_once( get_template_directory() .'/functions/theme-setup.php');
require_once( get_template_directory() .'/functions/welcome.php' );


/*--------------------------------------*/
/* Include helper functions
/*--------------------------------------*/
require_once( get_template_directory() .'/functions/post-types/portfolio.php' );
require_once( get_template_directory() .'/functions/post-types/services.php' );
require_once( get_template_directory() .'/functions/post-types/slides.php' );

require_once( get_template_directory() .'/functions/load-admin.php' );
require_once( get_template_directory() .'/functions/scripts.php' );

require_once( get_template_directory() .'/functions/header-css.php' );

require_once( get_template_directory() .'/functions/social.php' );

require_once( get_template_directory() .'/functions/widgets/widget-areas.php' );
require_once( get_template_directory() .'/functions/widgets/widget-posts-thumbs.php' );
require_once( get_template_directory() .'/functions/widgets/widget-portfolio-posts-thumbs.php' );

require_once( get_template_directory() .'/functions/font-awesome.php');

if( is_admin() ) {
	require_once( get_template_directory() .'/functions/dash-thumbs.php' );
	require_once ( get_template_directory() .'/functions/recommend-plugins.php' );
	require_once ( get_template_directory() .'/functions/meta/meta-slides.php');
	require_once ( get_template_directory() .'/functions/meta/meta-services.php' );
	require_once( get_template_directory() .'/functions/meta/gallery-metabox/gmb-admin.php' );
	
} else {
	require_once( get_template_directory() .'/functions/meta/gallery-metabox/gmb-display.php' );
	require_once( get_template_directory() .'/functions/posts-per-page.php' );
	require_once( get_template_directory() .'/functions/external-plugins-support.php' );
	require_once( get_template_directory() .'/functions/comments-callback.php');
	require_once( get_template_directory() .'/functions/image-default-sizes.php');
	require_once( get_template_directory() .'/functions/menu-walker.php');
	require_once( get_template_directory() .'/functions/pagination.php');
	require_once( get_template_directory() .'/functions/aqua-resizer.php');
	
}

/*
* ADDING OTHER OPTIONS TINYMCE EDITOR
*/

function enable_more_buttons($buttons) {

    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'styleselect';
    $buttons[] = 'backcolor';
    $buttons[] = 'newdocument';
    $buttons[] = 'cut';
    $buttons[] = 'copy';
    $buttons[] = 'charmap';
    $buttons[] = 'hr';
    $buttons[] = 'visualaid';

    return $buttons;
}
add_filter('mce_buttons_3', 'enable_more_buttons');

add_filter( 'tiny_mce_before_init', 'myformatTinyMCE' );
function myformatTinyMCE( $in ) {

$in['wordpress_adv_hidden'] = FALSE;

return $in;
}

/*
 * NEWSLETTER ADD CLASS TO BODY
 */

function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );



