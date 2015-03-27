<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/colorpicker.css" type="text/css" media="screen" />

<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,900' rel='stylesheet' type='text/css'/>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, span.overlay, a.zoom-icon, a.more-icon, #menu, #menu-right, #menu-content, ul#top-menu ul, #menu-bar, .footer-widget ul li, span.post-overlay, #content-area, .avatar-overlay, .comment-arrow, .testimonials-item-bottom, #quote, #bottom-shadow, #quote .container');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<script type="text/javascript">

  var _gaq = _gaq || [];
var pluginUrl = 
 '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
  _gaq.push(['_setAccount', 'UA-1172864-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div id="allcont">
	<div id="logo-container">
	
		<div class="container clearfix">

			<?php do_action('et_header_top'); ?>
			<div id="logo-area">
				<a href="<?php bloginfo('url'); ?>">
					<?php $logo = (get_option('feather_logo') <> '') ? get_option('feather_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?>
					<img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/>
				</a>
				<p id="slogan"><?php bloginfo('description'); ?></p>

<div id="logo-social">
<form method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>/">
    <div>
        <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="<?php esc_attr_e('Search','Feather'); ?>" />
    </div>
</form>
	<p><a href="http://www.facebook.com/CHCACT" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/facebook.png" class="social" alt="Friend me on Facebook" title="Like Us on Facebook"/></a>
	<a href="https://twitter.com/CTHealthCenters" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/twitter.png" alt="Follow us on Twitter" title="Follow us on Twitter"/></a>
	<a href="http://www.youtube.com/user/CHCACT" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/youtube.png" alt="Watch us on YouTube" title="Watch CHCACT's videos on YouTube"/></a>
	<a href="http://plus.google.com/114668826566209011499" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/googleplus.png" alt="Add us to your circles" title="Add us to your circles"/></a>
	<a href="http://www.linkedin.com/company/community-health-center-association-of-connecticut" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/linkedin.png" alt="Follow CHCACT on LinkedIn" title="Follow CHCACT on LinkedIn"/></a>
	<a href="http://pinterest.com/cthealthcenters/" target="_blank"><img src="http://www.get-centered.org/wp-content/plugins/social-sharing-toolkit/images/icons_large/pinterest.png" alt="Follow us on Pinterest" title="Follow us on Pinterest"/></a>
	<a href="http://www.get-centered.org" target="_blank"><img src="http://www.get-centered.org/2013/wp-content/uploads/2013/06/blog-30x30.png" alt="Read our blog at Get-Centered.org" title="Read our blog at Get-Centered.org" /></a></p>
<p><a href="http://www.chcact.org/wp-login.php">User Login</a></p>
	</div>
			</div>

<!-- end #logo-area -->

			<div id="menu">
				<div id="menu-right">
					<div id="menu-content" class="clearfix">
						<?php $menuClass = 'nav';
						$menuID = 'top-menu';
						$primaryNav = '';
						if (function_exists('wp_nav_menu')) {
							$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
						};
						if ($primaryNav == '') { ?>
							<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
								<?php if (get_option('feather_home_link') == 'on') { ?>
									<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php esc_html_e('Home','Feather') ?></a></li>
								<?php }; ?>

								<?php show_page_menu($menuClass,false,false); ?>
								<?php show_categories_menu($menuClass,false); ?>
							</ul> <!-- end ul#nav -->
						<?php }
						else echo($primaryNav); ?>
						
						<div id="et-social-icons">
							<?php
								$et_rss_url = get_option('feather_rss_url') <> '' ? get_option('feather_rss_url') : get_bloginfo('comments_rss2_url');
								if ( get_option('feather_show_twitter_icon') == 'on' ) $social_icons['twitter'] = array('image' => get_bloginfo('template_directory') . '/images/twitter.png', 'url' => get_option('feather_twitter_url'), 'alt' => 'Twitter' );
								if ( get_option('feather_show_rss_icon') == 'on' ) $social_icons['rss'] = array('image' => get_bloginfo('template_directory') . '/images/rss.png', 'url' => $et_rss_url, 'alt' => 'Rss' );
								if ( get_option('feather_show_facebook_icon') == 'on' ) $social_icons['facebook'] = array('image' => get_bloginfo('template_directory') . '/images/facebook.png', 'url' => get_option('feather_facebook_url'), 'alt' => 'Facebook' );
								$social_icons = apply_filters('et_social_icons', $social_icons);
								if ( !empty($social_icons) ) {
									foreach ($social_icons as $icon) {
										echo "<a href='" . esc_url($icon['url']) . "' target='_blank'><img alt='" . esc_attr($icon['alt']) . "' src='" . esc_url($icon['image']) . "' /></a>";
									}
								}
							?>
						</div>
					</div> <!-- end #menu-content -->		
				</div> <!-- end #menu-right -->		
			</div> <!-- end #menu -->
</div></div>

	<div id="top">
			<div class="clear"></div>

			<?php if ( !is_home() ) get_template_part('includes/top_info'); ?>
			<?php if ( get_option('feather_featured') == 'on' && is_home() ) get_template_part('includes/featured'); ?>		
			
		<!-- end .container -->
	</div><!-- end #top -->
	
	<div id="content">
		<div class="container">