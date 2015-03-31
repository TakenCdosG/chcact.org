<?php
/**
 * Array of social sites and HTML output
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */
 
 
// Create Social Array
if ( !function_exists('wpex_social_links') ) {
	
	function wpex_social_links() {
		
		$social_icons = array('twitter','google','facebook','linkedin','flickr','pinterest','github','behance','dribbble','forrst','youtube','vimeo','skype','paypal','envato','gowalla','icloud','evernote','quora','wordpress','rss');
		return apply_filters('wpex_social_links', $social_icons);
		
	}
	
}


// Display Social Icons
if ( !function_exists('wpex_display_social') ) {
	
	function wpex_display_social() {
		
		$wpex_social_links = wpex_social_links();
        $social_icons_message = array('twitter' => 'Follow us on Twitter','google' => 'add us to your circles','facebook' => 'Like us on Facebook','linkedin' => 'Follow CHCACT on LinkedIn','flickr' => 'flickr','pinterest' => 'Follow us on pinterest','github' => 'github','behance' => 'behance','dribbble' => 'dribbble','forrst' => 'forrst','youtube' => 'Watch CHCACT\'s videos on YouTube','vimeo' => 'vimeo','skype' => 'skype','paypal' => 'paypal','envato' => 'envato','gowalla' => 'gowalla','icloud' => 'icloud','evernote' => 'evernote','quora' => 'quora','wordpress' => 'wordpress','rss' => 'Read our blog at Get-Centered.org');


        if ( !$wpex_social_links ) return;
		
		$output = '<ul id="social" class="clr">';
			
				foreach ( $wpex_social_links as $social_link ) {
					
					if ( of_get_option( $social_link ) ) {
					
						$output .= '<li><a href="'. of_get_option( $social_link ) .'" title="'. $social_link .'" target="_blank"><img src="'. get_template_directory_uri() .'/images/social/'.$social_link.'.png" alt="'. $social_icons_message[$social_link] .'" /></a></li>';
					
					}
					
				}
				
		$output .= '</ul><!-- #social -->';
		
		echo apply_filters('wpex_display_social', $output);
	}
	
}