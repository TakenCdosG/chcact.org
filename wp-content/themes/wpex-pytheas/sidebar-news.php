<?php
/**
 * Created by PhpStorm.
 * User: caedlesu
 * Date: 26/06/15
 * Time: 1:27 PM
 */
?>
<div id="secondary" class="sidebar-container span_8 col news-sidebar" role="complementary">
    <div class="sidebar-inner newsletter-sidebar">
        <div class="widget-area">
            <?php //global $week_issue, $tweek; ?>

            <h4>In This Week's Issue</h4>
            <?php  echo get_field("week_issue"); ?>

            <h2>Follow Us</h2>
                <a href="http://www.facebook.com/chcact" target="_blank"><img src="http://www.get-centered.org/wp-content/uploads/2011/12/tiny_facebook_logo.png" alt="Facebook" /></a> <a href="http://www.twitter.com/CTHealthCenters" target="_blank"><img src="http://www.get-centered.org/wp-content/uploads/2011/12/tiny_twitter_logo.jpg" alt="Twitter" /></a> <a href="http://www.youtube.com/CHCACT" target="_blank"><img src="http://www.get-centered.org/wp-content/uploads/2011/12/tiny_youtube_logo.png" alt="YouTube" /></a><a href="http://www.linkedin.com/company/community-health-center-association-of-connecticut" target="_blank"><img src="http://www.get-centered.org/wp-content/uploads/2012/06/linkedin-30x30.jpg" alt="LinkedIn" /></a><a href="http://www.get-centered.org/" target="_blank"><img src="http://www.get-centered.org/wp-content/uploads/2012/04/blog-30x30.png" alt="Get-Centered.org" /></a>

            <h4>Tweet of the Week</h4>
            <?php echo get_field("tweek"); ?>


            <h2 id="SBIRT">New on Get-Centered</h2>
            <h2><a href="http://www.get-centered.org/"><img class="aligncenter  wp-image-5016" src="http://www.chcact.org/wp-content/uploads/2014/03/GC-header5.jpg" alt="Get Centered" width="214" height="39" /></a></h2>
            <p align="center">Our <a href="http://www.get-centered.org">Get-Centered Blog </a>features a new video about Charter Oak Health Center's Breast Cancer Screening &amp; Education Program, funded by the American Cancer Society!</p>

            <h2>SBIRT in Your Corner</h2>
            Learn more about CT SBIRT <a href="http://www.chcact.org/programs-services/screening-brief-intervention-referral-to-treatment/" target="_blank">here</a>!
        </div>
    </div>
</div>