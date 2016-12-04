<div id="sidebar" class="site-sidebar">

    <?php get_template_part( 'templates/parts/content-sidebar-title' ); ?>

    <div class="archive">
        <?php

        if( is_post_type_archive( 'business-tool' ) || is_singular( 'business-tool' ) ) {
            // print"a";
            wp_get_custom_pages( get_post_type() );
        }

        elseif( is_post_type_archive( 'publication' ) || is_singular( 'publication' ) || get_query_var( 'taxonomy' ) == 'publication_category' ) {
            // print"b";
            echo '<ul>';
            wp_list_categories(array(
                'title_li' => '',
                'taxonomy' => 'publication_category'
            ));
            echo '</ul>';
        }

        elseif( is_tax() || is_tag() || is_tag_page() || ( is_search() && is_archive() ) ) {
            wp_get_hierarchical_archives();
            //get_template_part( 'templates/parts/sidebar', 'tags' );
        }

        elseif(is_page()) {
            // print"d";
            get_template_part( 'templates/parts/sidebar', 'menu' );

        }

        elseif( ! is_search() ) {
            // print"e";
            
            wp_get_hierarchical_archives();
            get_template_part( 'templates/parts/sidebar', 'tags' );
        }
        ?>
    </div>
    
    <?php if ( is_active_sidebar( 'sidebar-news' ) && !is_post_type_archive( 'publication' ) && !is_post_type_archive( 'business-tool' ) && ( is_home() || is_singular( 'post' ) || is_archive( 'date' ) ) ) : ?>
        <div id="news-widget-area" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-news' ); ?>
        </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-publications' ) && ( is_post_type_archive( 'publication' ) || is_singular( 'publication' ) ) ) : ?>
        <div id="publications-widget-area" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-publications' ); ?>
        </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-bussiness-tools' ) && ( is_post_type_archive( 'business-tool' ) || is_singular( 'bussiness-tool' ) ) ) : ?>
        <div id="bussiness-tools-widget-area" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-bussiness-tools' ); ?>
        </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-page' ) && is_page() ) : ?>
        <div id="page-widget-area" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-page' ); ?>
        </div>
    <?php endif; ?>

</div>