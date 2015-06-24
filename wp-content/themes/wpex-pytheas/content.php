<?php
/**
 * The default template for displaying content. Used for both single and index/archive.
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */
 
 

/******************************************************
 * Single Posts
 * @since 1.0
*****************************************************/

if ( is_singular() && is_main_query() ) {
	 
	if( of_get_option('blog_single_thumbnail' ) == '1' && has_post_thumbnail() ) { ?>

	<?php }

}

/******************************************************
 * Entries
 * @since 1.0
*****************************************************/
else {
	
	global $wpex_count;
	$wpex_clr_margin = ( $wpex_count == 1 ) ? 'clr-margin' : NULL; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('blog-entry clr '. $wpex_clr_margin); ?>>
        <div class="corner-icon"></div>
		<div class="blog-entry-details">
			<header><h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2></header>
			<ul class="meta clr">
                <li><?php echo get_the_date("j F"); ?></li>
			</ul><!-- .meta -->
			<div class="blog-entry-content">
				<?php
				if ( of_get_option('blog_exceprt','1') == '1' ) {
					the_excerpt();
				} else {
					the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wpex' ) );
				} ?>
                <ul class="meta"><li>Categories: <span class="cat-style"><?php the_category(' / '); ?></span></li>
                    <?php if( comments_open() ) { ?>
                        <li class="comments-text"><div><span class="comment-link-text"><?php comments_popup_link(__('Leave a comment', 'wpex'), __('1 Comment', 'wpex'), __('% Comments', 'wpex'), 'comments-link', __('Comments closed', 'wpex')); ?></span><span class="news-comments"></span></div></li>
                    <?php } ?>
                </ul>
			</div><!-- /entry-content -->
		</div><!-- /blog-entry-details -->
	</article><!-- /blog-entry-entry -->

<?php } ?>