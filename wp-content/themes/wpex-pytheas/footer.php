<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */
?>


	</div><!-- /main-content -->
		<?php if( of_get_option( 'widgetized_footer' ) ) { ?>
			<footer id="footer" class="site-footer clr row">
                <div id="footer-menu" class="span_24 ">
                    <?php
                    wp_nav_menu( array(
                        'theme_location'	=> 'footer_menu',
                        'sort_column'		=> 'menu_order',
                        'fallback_cb'		=> '',
                        'walker' => new WPEX_Walker_Nav_Menu_footer()
                    )); ?>
                </div><!-- /footer-menu -->
			</footer><!-- #footer -->
		<?php } ?>
		<div id="footer-bottom" class="row clr">
            <div class="logo span_10">
                <?php if ( of_get_option('custom_logo') ) { ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo of_get_option('custom_logo'); ?>" alt="<?php echo get_bloginfo( 'name' ) ?>" /></a>
                <?php }?>
            </div><!-- .logo -->
			<div id="copyright" class="span_14 col" role="contentinfo">
				<?php
				// Copyright
				if ( of_get_option( 'custom_copyright' ) ) {
					echo do_shortcode( of_get_option( 'custom_copyright' ) );
				} ?>
			</div><!-- /copyright -->

		</div><!-- /footer-bottom -->
	</div><!-- /wrap -->

<?php wp_footer(); ?>
</body>
</html>