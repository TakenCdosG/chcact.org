<?php
/**
 * This file is used to display your homepage slides
 *
 * @package Fresh & Clean WordPress Theme
 * @since 1.0
 */

if ( '' != of_get_option( 'slides_alt' ) ) {
	
	echo do_shortcode( of_get_option( 'slides_alt' ) );
	
} else {

	// Get slides
	$wpex_query = new WP_Query(
		array(
			'post_type'			=> 'slides',
			'posts_per_page'	=> '-1',
			'no_found_rows'		=> true,
		)
	);
	// Display Slides
	if ( $wpex_query->posts ) {
		
		// Load slider scripts
		wp_enqueue_script('flexslider', get_template_directory_uri() .'/js/flexslider.js', array('jquery'), '2.0', true);
		wp_enqueue_script('wpex-slider-home', get_template_directory_uri() .'/js/slider-home.js', array('jquery','flexslider'), '1.0', true);
		
		// Set slider options
		$flex_params = array(
			'slideshow'			=> of_get_option('slides_slideshow', '0'),
			'randomize'			=> of_get_option('slides_randomize', '0'),
			'animation'			=> of_get_option('slides_animation', 'slide'),
			'direction'			=> of_get_option('slides_direction', 'horizontal'),
			'slideshowSpeed'	=> of_get_option('slideshow_speed', '7000'),
			'animationSpeed'	=> of_get_option('animation_speed', '600')
		);
		
		// Localize slider script
		wp_localize_script( 'wpex-slider-home', 'flexLocalize', $flex_params );?>
		<div id="home-slider-wrap" class="clr flexslider-container">
			<div id="home-slider" class="flexslider">
				<div id="home-slider-loader"><i class="fa fa-spinner fa-spin"></i></div>
				<ul class="slides">
					<?php foreach( $wpex_query->posts as $post ) : setup_postdata($post); ?>
					<?php if( has_post_thumbnail() || get_post_meta( get_the_ID(), 'wpex_slides_video', true ) ){ ?>
						<li>
							<div class="slide-inner">
								<?php if( '' != get_post_meta( get_the_ID(), 'wpex_slides_video', true ) ) { ?>
									<div class="fitvids"><?php echo wp_oembed_get( get_post_meta( get_the_ID(), 'wpex_slides_video', true ) ); ?></div>
								<?php } else {
									if( '' != get_post_meta( get_the_ID(), 'wpex_slides_url', true ) ) { ?>
									<a href="<?php echo get_post_meta( get_the_ID(), 'wpex_slides_url', true); ?>" title="<?php the_title_attribute(); ?>" target="_<?php echo get_post_meta( get_the_ID(), 'wpex_slides_url_target', true); ?>">
                                        <img class="news-slider-img" src="<?php echo aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ),  396, 233, wpex_img( 'slider_crop' ) ); ?>" alt="<?php the_title(); ?>" />
                                    </a>
									<?php } else { ?>
										<img class="news-slider-img" src="<?php echo aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ),  396, 233, wpex_img( 'slider_crop' ) ); ?>" alt="<?php the_title(); ?>" />
								<?php }
								 }

								 if( $post->post_content ) { ?>
									<div class="flex-cap">
                                        <a href="<?php echo get_post_meta( get_the_ID(), 'wpex_slides_url', true); ?>" title="<?php the_title_attribute(); ?>" target="_<?php echo get_post_meta( get_the_ID(), 'wpex_slides_url_target', true); ?>">
                                        <h2><?php the_title();?></h2>
                                        </a>
                                       <?php the_content(); ?>

                                    </div>
								<?php } ?>
							</div><!--/ slide-inner -->
						</li>
					<?php } ?>
					<?php endforeach; ?>
				</ul><!-- /slides -->
			</div><!-- /home-slider -->
		</div><!-- /home-slider-wrap -->
	<?php } wp_reset_postdata(); $wpex_query = NULL;
	
}