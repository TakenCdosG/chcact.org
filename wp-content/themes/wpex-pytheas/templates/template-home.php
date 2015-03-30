<?php
/**
	* This file controls the layout of your homepage
	*
	* @package WordPress
	* @subpackage Pytheas WordPress Theme
	* Template Name: Home
*/


get_header(); ?>

</div>
<?php
// Get homepage slider
get_template_part( 'content', 'slider' ); ?>

<div id="home-wrap" class="clr">

	<?php the_content(); ?>

	<?php
	/*--------------------------------------*/
	/* Recent Services Loop
	/*--------------------------------------*/
	if( of_get_option( 'home_services', '1' ) ) {
		
		$wpex_query = new WP_Query(
			array(
				'post_type'		=> 'services',
				'showposts'		=> of_get_option('home_services_count','6'),
				'no_found_rows'	=> true,
			)
		);
		
		if( $wpex_query->posts ) { ?>
		
		<div id="home-services" class="clr home-block">
			<?php
			// Display heading
			if( of_get_option( 'home_services_title', __( 'Services', 'wpex' ) ) ) { ?>
				<h2 class="heading">
					<span><?php echo of_get_option('home_services_title'); ?></span>
				</h2>
			<?php } ?>
			<div class="row clr">
				<?php
				// Begin Loop
				$wpex_count=0;
				foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
					$wpex_count++;
					get_template_part('content','services');
				if( $wpex_count==3) {
					echo '<div class="clr"></div>';
					$wpex_count=0;
				}
				endforeach; ?>
			 </div><!-- /row clr -->
		</div><!-- /home-services -->
		<?php
		}
		wp_reset_postdata(); $wpex_query = NULL;
		
	}
	
	
	
	/*--------------------------------------*/
	/* Recent Portfolio Loop
	/*--------------------------------------*/
	if( of_get_option( 'home_portfolio', '1' ) ) {
		
		$wpex_query = new WP_Query(
			array(
				'post_type'		=> 'portfolio',
				'showposts'		=> of_get_option('home_portfolio_count','4'),
				'no_found_rows'	=> true,
               /* 'orderby' => 'ORDER',*/
                'order'   => 'asc',
			)
		);
		
		if( $wpex_query->posts ) { ?>
			<div id="home-portfolio" class="clr home-block">
				<?php
				// Display heading
				if( of_get_option( 'home_portfolio_title', __( 'Portfolio', 'wpex' ) ) ) { ?>
					<h2 class="heading">
						<span><?php echo of_get_option('home_portfolio_title'); ?></span>
					</h2>
				<?php } ?>
				<div class="row clr">
					<?php
					// Begin Loop
					$wpex_count=0;
					foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
						$wpex_count++;
							get_template_part('content','portfolio');
						if( $wpex_count == 4 ) { echo '<div class="clr"></div>'; $wpex_count=0; }
					endforeach; ?>
				</div><!-- /row -->
			</div><!-- /home-portfolio -->
		<?php
		}
		wp_reset_postdata(); $wpex_query = NULL;
		
	} // End Portfolio Section



	/*--------------------------------------*/
	/* Tagline
	/*--------------------------------------*/
	if( of_get_option( 'home_tagline' ) ) { ?>

        <div id="home-tagline" class="clr home-block">
            <?php echo of_get_option('home_tagline','Home Tagline Sample'); ?>
        </div>
        <!-- /home-tagline -->

    <?php }

	/*--------------------------------------*/
	/* Recent Standard Posts
	/*--------------------------------------*/
	if( of_get_option( 'home_blog', '1' ) ) {
		
		$wpex_query = new WP_Query(
			array(
				'post_type'				=> 'post',
				'showposts'				=> of_get_option('home_blog_count','4'),
				'no_found_rows'			=> true,
				'ignore_sticky_posts'	=> true
			)
		);
		
		if( $wpex_query->posts ) { ?>
			<div id="home-blog" class="row clr home-block">
				<?php
				// Display heading
				if( of_get_option('home_blog_title') ) { ?>
					<h2 class="heading">
						<span><?php echo of_get_option( 'home_blog_title', __( 'Blog', 'wpex' ) ); ?></span>
					</h2>
				<?php } ?>
				<div class="row clr">

                    <div id="home-twitter" class="col span_10">
                        twitter
                    </div>

                    <div id="home-about" class="col span_7">
                        about
                    </div>

                    <div id="home-news" class="col span_6">
                        <?php
					// Begin Loop
					$wpex_count=0;
					foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
						$wpex_count++;
						$wpex_clr_margin = ( $wpex_count == 1 ) ? 'clr-margin' : NULL; ?>
					<div <?php post_class('home-blog-entry '. $wpex_clr_margin); ?>>

						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="home-blog-entry-excerpt">
							<?php 
							// Display excerpt
							echo ( !empty( $post->post_excerpt ) ) ?
								apply_filters('the_content', get_the_excerpt() ) :
									wp_trim_words( strip_shortcodes( get_the_excerpt() ), of_get_option('portfolio_entry_excerpt_length','12') ); ?>
						</div><!-- /home-blog-entry-excerpt -->
					</div><!-- /home-blog-entry -->
					<?php
					if( $wpex_count==4) {
						echo '<div class="clr"></div>';
						$wpex_count=0;
					}
					endforeach; ?>
                    </div>


				</div><!-- /row -->
			</div><!-- /home-blog -->
		<?php
		}
		wp_reset_postdata(); $wpex_query = NULL;
		
	} // End Blog Section ?>

</div><!-- /home-wrap -->
 
<?php get_footer();?>