<?php get_header();

$post_type = ( isset( $_GET['post_type'] ) ) ? $_GET['post_type'] : false;

$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 10 ) );
query_posts( $args );

$s = $_GET['s'];
?>

    <div class="container">

        <div class="row">
  
            <div class="col-xs-12 col-sm-8 main-column pull-right">
                <div id="content" class="site-content">

                    <?php

                    if ( have_posts() ) {

                        if ( ! $post_type || $post_type == 'publication' ):

                            wp_reset_postdata();

                            $args = array(
                                'post_type' => 'publication',
                                's' => "'$s'",
                                'posts_per_page' => -1
                            );

                            $query = new WP_Query( $args );

                            if ( $query->have_posts() ) :

                                echo '<h2 class="search-category-title">' . __( 'Publications', 'website' ) . '</h2>';

                                while ( $query->have_posts() ) {

                                    $query->the_post();

                                    get_template_part( 'templates/parts/content', get_post_format() );

                                }

                            endif; 

                        endif;

                        if ( ! $post_type || $post_type == 'business-tool' ):

                            wp_reset_postdata();

                            $args = array(
                                'post_type' => 'business-tool',
                                's' => "'$s'",
                                'posts_per_page' => -1
                            );

                            $query = new WP_Query( $args );

                            if ( $query->have_posts() ) :

                                echo '<h2 class="search-category-title">' . __( 'Buisness Tools', 'website' ) . '</h2>';

                                while ( $query->have_posts() ) {

                                    $query->the_post();

                                    get_template_part( 'templates/parts/content', get_post_format() );

                                }

                            endif;

                        endif;

                        if ( ! $post_type || $post_type == 'post' ):

                            wp_reset_postdata();

                            $args = array(
                                'post_type' => 'post',
                                's' => "'$s'",
                                'posts_per_page' => -1
                            );

                            $query = new WP_Query( $args );

                            if ( $query->have_posts() ) :

                                echo '<h2 class="search-category-title">' . __( 'News', 'website' ) . '</h2>';

                                while ( $query->have_posts() ) {

                                    $query->the_post();

                                    get_template_part( 'templates/parts/content', get_post_format() );

                                }

                            endif;

                        endif;

                        if ( ! $post_type || $post_type == 'page' ):

                            wp_reset_postdata();

                            $args = array(
                                'post_type' => 'page',
                                's' => "'$s'",
                                'posts_per_page' => -1
                            );

                            $query = new WP_Query( $args );

                            if ( $query->have_posts() ) :

                                echo '<h2 class="search-category-title">' . __( 'Pages', 'website' ) . '</h2>';

                                while ( $query->have_posts() ) {

                                    $query->the_post();

                                    get_template_part( 'templates/parts/content', 'post' );

                                }

                            endif;

                            wp_reset_postdata();

                        endif;

                    } else {

                        get_template_part( 'templates/parts/content', 'none' );

                    }
                    ?>

                    <footer class="content-footer">
                        <?php //paging_navigation(); ?>
                    </footer>

                </div>
            </div>

            <div class="col-xs-12 col-sm-4 sidebar-column">
                <?php get_sidebar(); ?>
            </div>

        </div>

    </div>

<?php get_footer(); ?>
