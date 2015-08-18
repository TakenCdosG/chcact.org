<?php
/**
 * Template Name: Webinars
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

        <div id="content" class="site-content span_18 col" role="main">

            <h1 class="webinar-title">Current Webinars</h1>

            <?php
            //get current page ID
            $the_id = get_the_ID();

            $args = array(
                'child_of'     => $the_id,
                'title_li'     => '',
                'depth'			=> 0,
                'sort_order'	=> 'DESC',
                'sort_column'	=> 'menu_order'
            );

            $pages = get_pages( $args );

            $output = '';

            foreach($pages as $value){

                //echo '<pre>'.var_dump($value).'</pre>';

                $thumb = get_the_post_thumbnail( $value->ID, array(200,200), $attr = '' );
                $output .= "<div class='webinar-container content-area row'>";
                    $output .= "<div class='featured-web-img span_7 col'><a href='" . $value->post_name . "' >" . $thumb . "</a></div>";
                    $output .= "<div class='webinar-info span_16 col'>";
                        $output .= "<div class='single-web-title'><a href='" . $value->post_name . "' >" .  $value->post_title . "</a></div>";
                        $output .= "<div class='webinar-excerpt'>". wp_trim_words($value->post_content,30) ."<a href='" . $value->post_name . "' ><span class='right-arrow'>&nbsp; &#10142;</span></a></div>";
                    $output .= "</div>";
                $output .= "</div>";
            }

            echo $output;
            ?>

        </div><!-- #content -->

        <div id="dropdown-webinars" class="clr-margin span_6 col webinars-archive">
            <p class="previous-webs">Previous Webinars</p>
        </div><!-- /footer-menu -->

    </div><!-- #primary -->

<?php get_footer(); ?>