<h3 class="block-title"><a href="<?php echo get_post_type_archive_link( 'business-tool' ); ?>"><?php _e('Tools', THEME_DOMAIN); ?></a></h3>
<?php
global $post;
$posts = get_posts(array(
    'post_parent' => 0,
    'post_type' => 'business-tool',
    'post_status' => 'publish',
    'orderby' => 'post_date',
    'order' => 'DESC'
));

if($posts) {
    
    echo '<div data-slider-id="business-tools" class="row slider">';
    foreach ($posts as $key => $post) {
        setup_postdata( $post );

        echo '<div class="col-xs-12 col-sm-4">';
            get_template_part( 'templates/parts/front-page', 'business-tool' );
        echo '</div>';
    }
    echo '</div>';

} else {

    get_template_part( 'templates/parts/content', 'none' );

}
?>