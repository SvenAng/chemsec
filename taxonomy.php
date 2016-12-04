<?php
global $wp_query;

get_header();

if(is_tag_page()) {

    $tags = $wp_query->query_vars['tag'];
    $tags = explode('+', $tags);

    $posts = get_chemsec_posts( $tags );

    $posts_ids = array_map(function( $post ) {
        return $post->ID;
    }, $posts);

    $args = array(
        'post_type' => array('post', 'publication', 'business-tool'),
        'posts_per_page' => 10,
        'post__in' => $posts_ids
    );

    $query_vars = $wp_query->query_vars;
    query_posts( $args );
    $wp_query->query_vars = $query_vars; // just reset query vars so we can use our custom function
} else {
    $args = array_merge( $wp_query->query, array( 'posts_per_page' => 10 ) );
    query_posts( $args );  
} 

?>

    <div class="container">

        <div class="row">
  
            <div class="col-xs-12 col-sm-8 main-column pull-right">
                <div id="content" class="site-content">

                    <?php
                    if ( have_posts() ) {

                        while ( have_posts() ) {

                            the_post();

                            get_template_part( 'templates/parts/content' );

                        }

                    } else {

                        get_template_part( 'templates/parts/content', 'none' );

                    }
                    ?>

                    <footer class="content-footer">
                        <?php paging_navigation(); ?>
                    </footer>

                </div>
            </div>

            <div class="col-xs-12 col-sm-4 sidebar-column">
                <?php get_sidebar(); ?>
            </div>

        </div>

    </div>

<?php
get_footer();
?>
