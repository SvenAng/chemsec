<?php get_header();

$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 10 ) );
query_posts( $args );
?>

    <div class="container">

        <div class="row">
  
            <div class="col-xs-12 col-sm-8 main-column pull-right">
                <div id="content" class="site-content">

                    <header class="content-header">
                        <?php if( is_search() && isset($_GET['s']) ): ?>
                            <h2 class="page-title"><?php printf( __( 'Search Results for: %s', THEME_DOMAIN ), get_search_query() ); ?></h2>
                        <?php endif; ?>
                    </header>

                    <?php
                    if ( have_posts() ) {

                        while ( have_posts() ) {

                            the_post();

                            if( is_singular() ) {
                                get_template_part( 'templates/parts/content', 'single' );
                            } else {
                                get_template_part( 'templates/parts/content', get_post_format() );
                            }

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

<?php get_footer(); ?>
