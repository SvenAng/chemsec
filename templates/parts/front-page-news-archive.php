<div class="news-archive-block">
    <h3 class="block-title"><a href="<?php echo get_post_type_archive_link( 'publication' ); ?>"><?php _e('Latest Publications', THEME_DOMAIN); ?></a></h3>

    <?php
        global $post;
        $posts = get_posts(array(
            'numberposts' => 3,
            'post_type' => 'publication',
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC'
        ));

        if($posts) {

            foreach ($posts as $post) {
                setup_postdata( $post );

                get_template_part( 'templates/parts/content', 'latest-news-archive' );
            }

        }
    ?>

    <a class="more-posts orange-button" href="<?php echo get_post_type_archive_link( 'publication' ); ?>"><?php _e('More publications', THEME_DOMAIN); ?></a>

</div>