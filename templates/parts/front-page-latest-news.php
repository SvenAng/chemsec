<div class="news-block">
    <h3 class="block-title"><a href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php _e('News', THEME_DOMAIN); ?></a></h3>

    <?php
        global $post;
        $posts = get_posts(array(
            'numberposts' => 3,
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC'
        ));

        if($posts) {

            foreach ($posts as $post) {
                setup_postdata( $post );

                get_template_part( 'templates/parts/content', 'latest-news' );
            }

        } else {

            get_template_part( 'templates/parts/content', 'none' );

        }
    ?>

    <a class="more-posts orange-button" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>"><?php _e('More news', THEME_DOMAIN); ?></a>

    <!-- <a class="newsletter orange-button" href="#signup"><?php _e('Sign up', THEME_DOMAIN); ?></a> -->
    <a class="orange-button" href="#" data-featherlight="#mylightbox">Sign Up For Newsletter</a>
<div id="mylightbox" class="mylightbox">
    <h2 class="widget-title">Sign up for ChemSec's newsletter</h2>
    <form data-name="Default sign-up form" data-id="896" method="post" class="mc4wp-form mc4wp-form-896 mc4wp-form-basic" id="mc4wp-form-1">
        <div class="mc4wp-form-fields"><p>
        <input type="email" required="required" placeholder="Email" name="EMAIL">
        </p>
        <p>
            <input type="text" placeholder="Name" name="MMERGE4">
        </p>
        <p>
            <input type="text" placeholder="Company" name="MMERGE5">
        </p>
        <p>
            <input type="submit" class="orange-button submit" value="Subscribe">
        </p>
        <div style="display: none;">
            <input type="text" autofill="off" autocomplete="off" tabindex="-1" value="" name="_mc4wp_honeypot">
        </div>
            <input type="hidden" value="1459351343" name="_mc4wp_timestamp">
            <input type="hidden" value="896" name="_mc4wp_form_id">
            <input type="hidden" value="mc4wp-form-1" name="_mc4wp_form_element_id"></div>
        <div class="mc4wp-response"></div>
    </form>
</div>


    
</div>