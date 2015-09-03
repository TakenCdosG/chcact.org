<?php
/**
 * Template Name: Webinar Archives
 * The template for displaying Webinars Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Pytheas
 * @since Pytheas 1.0
 */

get_header(); ?>
    </div>
    <div id="primary" class="content-area row clr">
        <div id="content" class="site-content span_18 col" role="main">

            <h1>
                <?php the_title(); // this should output Archive Page ?>
            </h1>

            <?php

            // set up our archive arguments
            $archive_args = array(
                'post_type' => 'page',    // get only posts
                'posts_per_page'=> 10 ,
                'cat'=> 60,
                //'meta_query' => array(array('key' => '_thumbnail_id'))
            );

            $archive_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
            // new instance of WP_Query
            $archive_query = new WP_Query( $archive_args );
            $temp_query = $wp_query;
            $wp_query   = NULL;
            $wp_query   = $archive_query;
            ?>

            <div class="loop-archive">

                <?php $date_old = ""; // assign $date_old to nothing to start

                ?>
                <?php while ( $archive_query->have_posts() ) : $archive_query->the_post(); // run the custom loop ?>

                    <?php $date_new = get_the_time("F Y"); // get $date_new in "Month Year" format ?>

                    <?php if ( $date_old != $date_new ) : // run the check on $date_old and $date_new, and output accordingly ?>
                        <h2><?php echo $date_new; ?></h2>
                    <?php endif; ?>

                    <article <?php post_class(); // output a post article ?>>
                        <p class="webinar-archive-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></p>
                    </article>

                    <?php $date_old = $date_new; // update $date_old ?>

                <?php endwhile; // end the custom loop ?>



            </div>
            <?php wp_reset_postdata(); ?>
            <div class="navi-links span_10 col">
                <span class="prev-link"><?php previous_posts_link( 'Newer Webinars' ); ?> </span>
                <span class="next-link"><?php next_posts_link( 'Older Webinars', $archive_args->max_num_pages );?></span>
            </div>
            <?php
            $wp_query = NULL;
            $wp_query = $temp_query;
            ?>
        </div>
    </div>

<?php get_footer(); ?>