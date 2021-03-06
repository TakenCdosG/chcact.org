<?php
/**
 * Template Name: Full
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */

get_header(); ?>

		<header class="page-header">
			<h1 class="page-header-title"><?php the_title(); ?></h1>
		</header>
	</div>

	<div id="primary" class="content-area row clr">
		<div id="left-menu" class="clr-margin span_6  col">
			<?php
			wp_nav_menu( array(
				'theme_location'	=> 'footer_menu',
				'sort_column'		=> 'menu_order',
				'fallback_cb'		=> '',
				'walker' => new WPEX_Walker_Nav_Menu_left()
			)); ?>
		</div><!-- /footer-menu -->
		<div id="content" class="site-content span_18 col" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content entry clr">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links clr">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<?php edit_post_link( __( 'Edit Page', 'wpex' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>