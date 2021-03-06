<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<header class="page-header">
		<h1 class="page-header-title"><?php the_title(); ?></h1>
		<nav class="single-nav clr"> 
			<?php next_post_link('<div class="single-nav-left">%link</div>', '<span class="fa fa-chevron-left"></span>', false); ?>
			<?php previous_post_link('<div class="single-nav-right">%link</div>', '<span class="fa fa-chevron-right"></span>', false); ?>
		</nav><!-- .page-header-title --> 
	</header><!-- .page-header -->
	
	<div id="primary" class="content-area span_16 col clr clr-margin">
		<div id="content" class="site-content" role="main">
			<?php if ( !post_password_required() ) { ?>

			<?php get_template_part('content', get_post_format() ); ?>
			<?php } ?>
			<article class="entry clr">
				<?php the_content(); ?>
			</article><!-- /entry -->
			<?php
			// Post pagination
			wp_link_pages( array( 'before' => '<div class="page-links clr">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			<?php
			// Tags
			if ( of_get_option( 'blog_tags', '1' ) ) { ?>
				<?php the_tags('<div class="post-tags clr">','','</div>'); ?>
			<?php } ?>
			<?php
			// Author bio
			if ( of_get_option('blog_bio', '1' ) && get_the_author_meta( 'description' ) ) { ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php } ?>

			<?php comments_template(); ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php endwhile; ?>
<?php if (is_single() && in_category('News') ) {
    get_sidebar('news'); }?>
<?php get_footer(); ?>