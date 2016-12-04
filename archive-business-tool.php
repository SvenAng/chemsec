<?php get_header();

$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 6, 'post_parent' => 0 ) );
query_posts( $args );
?>

    <div class="container">

        <div class="row">
  
            <div class="col-xs-12 col-sm-8 main-column pull-right">
                <div id="content" class="site-content">

                        <div id="business-tools" class="row">

                            <?php
                            if ( have_posts() ) {

                                while ( have_posts() ) {

                                    the_post();

                                    if( is_singular() ):
                                        get_template_part( 'templates/parts/content', 'single' );
                                    else: ?>
                                        <div class="col-xs-12 col-sm-6">
                                            <?php get_template_part( 'templates/parts/content', 'business-tool' ); ?>
                                        </div>
                                    <?php endif;

                                }

                            } else {

                                get_template_part( 'templates/parts/content', 'none' );

                            }
                            ?>
                            
                        </div>

                    <footer class="content-footer">
                        <?php paging_navigation(); ?>
                    </footer>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4 sidebar-column">
                <?php get_sidebar('business-tools'); ?>
            </div>

        </div>

    </div>

<?php get_footer(); ?>
