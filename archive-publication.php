<?php
global $wp_query, $first_post;

get_header();
$page = get_query_var('paged');
$posts_per_page = $page < 2 ? 7 : 6; // on the overview page we want 7 posts and the rest 6

// Wordpress runs this with post_type = post if the url is http://127.0.0.1/chemsec/publication/reach/
// so we'll do this to override that
$args = array_merge( $wp_query->query_vars, array( 'post_type' => 'publication', 'posts_per_page' => $posts_per_page ) );
query_posts( $args );
$mypostsantal = $wp_query->post_count;
$args2 = array('post_type' => 'publication','meta_query' => array( array('key' => 'featured', 'value' => 'Yes',)));
$postslist = get_posts( $args2 );

?>

    <div class="container">

        <div class="row">
   
            <div class="col-xs-12 col-sm-8 main-column pull-right">
                
                <div id="content" class="site-content">

                    <?php if ( have_posts() ): ?>

                        <div id="publications">
                            
                                <div id="latest-publication" class="row">
                                    <div class="col-xs-12">
                                        <header class="content-header">
                                            <?php if( is_search() && isset($_GET['s']) ): ?>
                                                <h2 class="page-title"><?php printf( __( 'Search Results for: %s', THEME_DOMAIN ), get_search_query() ); ?></h2>
                                            <?php elseif( is_category( ) ): ?>
                                                <h2 class="page-title"><?php printf(__('Featured %s publication', THEME_DOMAIN), single_cat_title('', false)); ?></h2>
                                            <?php else: ?>
                                                <h2 class="page-title"><?php _e('Featured publication', THEME_DOMAIN); ?></h2>
                                            <?php endif; ?>
                                        </header>

                                        <?php
                                             foreach ( $postslist as $post) {
                                                setup_postdata( $post );
                                                get_template_part( 'templates/parts/content', 'publication' );   
                                        
                                            }
                                        ?>
                                         
                                    </div>
                                </div>
                            

                            <div id="all-publications" class="row">
                                <div class="col-xs-12">
                                    <header class="content-header">
                                        <?php if( is_category( ) ): ?>
                                            <h2 class="page-title"><?php printf(__('All publications about %s', THEME_DOMAIN), single_cat_title('', false)); ?></h2>
                                        <?php elseif( !isset($_GET['s']) ): ?>
                                            <h2 class="page-title"><?php _e('All publications', THEME_DOMAIN); ?></h2>
                                        <?php endif; ?>
                                    </header>

                                    <?php

                                        $index = 0;
                                        $counter = 1;
                                        while ( have_posts() ) {
                                            
                                            if( $index  == 3 ) {  
                                                $index = 0;
                                            }

                                            the_post();
                                            
                                            if(get_field('featured') !='Yes'){ 
                                                  
                                                if( $index  == 0 ) {
                                                    echo '<div class="row">';
                                                }

                                                echo '<div class="col-sm-4">'; 
                                                    // print $index;
                                                    get_template_part( 'templates/parts/content', 'publication' );
                                                echo '</div>';
                                                
                                                    
                                                
                                                if( $index  == 2 || $counter == $mypostsantal) {
                                                    echo '</div>';
                                                    
                                                }
                                                
                                                $index++;
                                                $counter++;
                                                
                                            }
                                        }
                                    ?>

                                </div>

                            </div>

                        </div>


                    <?php else:

                        get_template_part( 'templates/parts/content', 'none' );

                    endif;
                    ?>

                    <footer class="content-footer">
                        <?php paging_navigation(); ?>
                    </footer>

                <!-- </div> -->
            </div>
            
            </div>

            <div class="col-xs-12 col-sm-4 sidebar-column">
                <?php get_sidebar(); ?>
            </div>

        </div>

    </div>

<?php get_footer(); ?>
