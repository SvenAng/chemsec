<?php
/*
 * hook-functions.php
 * Is a file that contains functions that are called by wordpress hooks
 * These should be as generic as possible and call other custom functions.
 * I.e. Its better to call a function from custom-functions than to write the whole function in here.
 * Ex. functions.php -> hook-functions.php -> custom-functions.php
 */

function init_function() {

    // Register styles and scripts
    wp_register_style(  'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,700italic,700,300,600;Raleway:500,600,700');
     wp_register_style(  'tmp-css',     TEMPLATE_CSS_DIRECTORY_URI . '/tmp.css');
    wp_register_style(  'main-css',     TEMPLATE_CSS_DIRECTORY_URI . '/main.min.css',               array( 'google-fonts' ) );
    wp_register_script('custom-script', TEMPLATE_JS_DIRECTORY_URI . '/tmp.js',                      array( 'jquery' ), false, true );
    wp_register_script( 'main-js',  TEMPLATE_JS_DIRECTORY_URI . '/main.min.js',                array( 'jquery' ), false, true );
    // wp_register_script( 'main-js',  TEMPLATE_JS_DIRECTORY_URI . '/main.js',                         array( 'jquery' ), false, true );
    wp_register_style(  'override-css',     TEMPLATE_CSS_DIRECTORY_URI . '/override.css');
    

    // RENAME POSTS TO NEWS
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';

    $wp_post_types['post']->label = 'News';

    // POST TYPES
    register_taxonomy( 'business-tool_tag', 'business-tool', array(
        'hierarchical' => false,
        'query_var' => 'business-tool_tag',
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        '_builtin' => true,
        'rewrite' => array(
            'hierarchical' => false,
            'slug' => 'business-tool/keyword',
            'with_front' => false
        )
    ) );

    register_post_type( 'business-tool', array(
            'labels' => array(
                'name' => __( 'Business Tools', THEME_DOMAIN ),
                'singular_name' => __( 'Business Tool', THEME_DOMAIN )
            ),
            'taxonomies' => array('business-tool_tag'),
            'public' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'revisions',
                'page-attributes'
            ),
            'rewrite' => array(
                'slug' => __('business-tool'),
                'width_front' => false
            )
        )
    );


    // Deregister category
    // register_taxonomy('category', array());

    // Reregister category for just publication
    register_taxonomy( 'publication_category', 'publication', array(
            'label' => __( 'Categories', THEME_DOMAIN ),
            'rewrite' => array(
                'slug' => 'publication/category',
                'with_front' => false
            ),
            'hierarchical' => true,
        )
    );

    register_taxonomy( 'publication_tag', 'publication', array(
        'hierarchical' => false,
        'query_var' => 'publication_tag',
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        '_builtin' => true,
        'rewrite' => array(
            'hierarchical' => false,
            'slug' => 'publication/keyword',
            'with_front' => false
        )
    ) );

    register_post_type( 'publication', array(
            'labels' => array(
                'name' => __( 'Publications', THEME_DOMAIN ),
                'singular_name' => __( 'Publication', THEME_DOMAIN )
            ),
            'taxonomies' => array('publication_tag', 'publication_category'),
            'hierarchical' => false,
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'revisions',
                'page-attributes'
            ),
            'rewrite' => array(
                'slug' => 'publication',
                'width_front' => false
            )
        )
    );


    // WIDGETS
    register_sidebar(array(
        'id'          => 'sidebar-news',
        'name'        => __( 'Sidebar: News', THEME_DOMAIN ),
        'description' => __( 'This sidebar is located in the sidebar on the News page.', THEME_DOMAIN ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ));

    register_sidebar(array(
        'id'          => 'sidebar-publications',
        'name'        => __( 'Sidebar: Publications', THEME_DOMAIN ),
        'description' => __( 'This sidebar is located in the sidebar on the Publications page.', THEME_DOMAIN ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ));

    register_sidebar(array(
        'id'          => 'sidebar-bussiness-tools',
        'name'        => __( 'Sidebar: Bussiness Tools', THEME_DOMAIN ),
        'description' => __( 'This sidebar is located in the sidebar on the Bussiness Tools page.', THEME_DOMAIN ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ));

    register_sidebar(array(
        'id'          => 'sidebar-page',
        'name'        => __( 'Sidebar: Pages', THEME_DOMAIN ),
        'description' => __( 'This sidebar is located in the sidebar on all regular pages.', THEME_DOMAIN ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ));


    // index.php?post_tag=$matches[1]&publication_tag=$matches[1]&business-tool_tag=$matches[1]
    // add_rewrite_rule('keyword/([^/]+)', 'index.php?tag=$matches[1]&publication_tag=$matches[1]&business-tool_tag=$matches[1]', 'top');
}


function after_setup_theme_function() {

    // Add localization
    load_theme_textdomain( THEME_DOMAIN, TEMPLATE_DIRECTORY . '/includes/languages' );

    // add thumbnail support
    add_theme_support( 'post-thumbnails' );

    // Add RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // adds <title>
    add_theme_support( 'title-tag' );

    // Thumbnail sizes
    if ( function_exists( 'add_image_size' ) ) {

        add_image_size( 'business-group', 120, 100, false );
        add_image_size( 'business-tool', 260, 60, false );
        add_image_size( 'business-tool-large', 360, 90, false );
        add_image_size( 'front-page-header', 1600, 0, false );
        add_image_size( 'publication-large', 363, 363, true );
        add_image_size( 'publication', 220, 220, true );
        add_image_size( 'publication-list', 220, 0, false );
        add_image_size( 'new-publication', 220, 420, false );
        add_image_size( 'single-post', 739, 739, false );

    }

    // register menus
    register_nav_menus( array(
        'main-menu' => __( 'Main Menu', THEME_DOMAIN ),
        'sidebar-menu' => __( 'Sidebar Menu', THEME_DOMAIN ),
    ) );
}

function wp_enqueue_scripts_function() {

    // Enqueue styles and scripts
    wp_enqueue_style(  'google-fonts' );
    wp_enqueue_style(  'main-css' );
    wp_enqueue_style(  'tmp-css' );
    wp_enqueue_style(  'override-css' );
    wp_enqueue_script( 'main-js' );
    wp_enqueue_script( 'custom-script' );
    

    // html5shiv for IE
    add_action( 'wp_head', function() {
        echo '<!--[if lt IE 9]>';
        echo '<script type="text/javascript" src="' . esc_url( TEMPLATE_JS_DIRECTORY_URI ) . '/lib/html5shiv-printshiv.min.js"></script>';
        echo '<script type="text/javascript" src="' . esc_url( TEMPLATE_JS_DIRECTORY_URI ) . '/lib/respond.min.js"></script>';
        echo '<![endif]-->';
    } );
    
    // inject usefull stuff for js
    global $wp_query;
    wp_localize_script( 'main-js', 'wp', array(
        'baseurl'  => get_bloginfo('wpurl').'/index.php',
        'ajaxurl'  => admin_url('admin-ajax.php'),
        'paged'    => get_query_var('paged') ? get_query_var('paged') : 1,
        'numpages' => $wp_query->max_num_pages,
        'post_type' => get_post_type()
    ));
}

function get_menu_item_parent_id( $sorted_menu_items ) {
    global $menu_item_parent_id;

    foreach ( $sorted_menu_items as $menu_item ) {
        if ( $menu_item->current && $menu_item->object == 'page' ) {
            $menu_item_parent_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
            break;
        }
    }

    return $sorted_menu_items;
}

function admin_menu_function() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    // $submenu['edit.php'][16][0] = 'News Tags';
}

function set_excerpt_length() {
    $post_type = get_post_type();
    $excerpt_length = 40;

    if( is_front_page() ) {

        if( $post_type == 'business-tool' ) {
            $excerpt_length = 15;
            
            if( !has_post_thumbnail() ) {
                $excerpt_length = 35;
            }
        }

        elseif( $post_type == 'publication' ) {
            $excerpt_length = 20;
        }

    } else {
        if( $post_type == 'business-tool' ) {
            $excerpt_length = 20;

            if( !has_post_thumbnail() ) {
                $excerpt_length = 50;
            }
        }
    }

    return $excerpt_length;
}
function set_excerpt_more( $more ) {
    return '...';
}


add_action( 'wp_ajax_get_posts', 'get_posts_by_tags' );
add_action( 'wp_ajax_nopriv_get_posts', 'get_posts_by_tags' );
function get_posts_by_tags() {

        global $post, $wp_query;

        $tags = (array) $_POST['tags'];
        $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : false;

        $args_tags = array();
        if (isset( $_POST['tags'] ) ) {
            foreach ($_POST['tags'] as $tag) {
                $args_tags[] = array(
                    'taxonomy' => $tag['taxonomy'],
                    'field' => 'slug',
                    'terms' => $tag['slug']
                );
            }
        }

        $args = array(
            'posts_per_page' => 10,
            'post_type' => $post_type,
            'post_status' => 'publish',
            'paged' => $paged,
            'tax_query' => $args_tags
        );

        if($post_type == false) {
            $posts = get_chemsec_posts( $_POST['tags'] );

            $posts_ids = array_map(function( $post ) {
                return $post->ID;
            }, $posts);

            $args = array(
                'posts_per_page' => 10,
                'post_type' => array('post', 'publication', 'business-tool'),
                'post_status' => 'publish',
                'post__in' => $posts_ids,
                'paged' => $paged
            );
            
        }

        ob_start();
        $posts = new WP_Query( $args );
        $result['numpages'] = $posts->max_num_pages;
        $result['paged'] = $paged;
        $html = '';

        if ( $posts->have_posts() ) {
            $result = array();

            while ( $posts->have_posts() ) {
                $posts->the_post();

                get_template_part( 'templates/parts/content' );
            }
        } else {
            get_template_part( 'templates/parts/content', 'none' );
        }

        $html = ob_get_clean();
        $result['html'] = $html;
        wp_reset_postdata();
        die(json_encode($result));


    die;
}


add_action( 'wp_ajax_get_newsletter_form', 'get_newsletter_form' );
add_action( 'wp_ajax_nopriv_get_newsletter_form', 'get_newsletter_form' );
function get_newsletter_form() {
        
    the_widget( 'MC4WP_Lite_Widget', array(
            'title' => __('Newsletter')
        ), array(
            'id'          => 'sidebar-bussiness-tools',
            'name'        => __( 'Sidebar: Bussiness Tools', THEME_DOMAIN ),
            'description' => __( 'This sidebar is located in the sidebar on the Bussiness Tools page.', THEME_DOMAIN ),
            'before_widget' => '<aside id="mc4wp_widget-99" class="widget widget_mc4wp_widget">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>'
    ));

    die;
}


/******************************************
 ADD CUSTOM PERMALINK FOR CUSTOM POST TYPE
******************************************/

// Add our custom permastructures for custom taxonomy and post
function wp_loaded_function() {
    global $wp_rewrite;
    add_permastruct( 'publication_category', 'publication/%publication_category%', false );
    add_permastruct( 'publication', 'publication/%publication_category%/%publication%', false );
}

// Make sure that all links on the site, include the related texonomy terms
function post_type_link_function( $permalink, $post ) {
    if ( $post->post_type !== 'publication' )
        return $permalink;
    $terms = get_the_terms( $post->ID, 'publication_category' );
    
    if ( ! $terms )
        return str_replace( '%publication_category%/', '', $permalink );
    $post_terms = array();
    foreach ( $terms as $term )
        $post_terms[] = $term->slug;
    return str_replace( '%publication_category%', implode( ',', $post_terms ) , $permalink );

}

// Make sure that all term links include their parents in the permalinks
function term_link_function( $permalink, $term ) {
    $term_parents = get_term_parents( $term );
    foreach ( $term_parents as $term_parent )
        $permlink = str_replace( $term->slug, $term_parent->slug . ',' . $term->slug, $permalink );
    return $permlink;
}

// Helper function to get all parents of a term
function get_term_parents( $term, &$parents = array() ) {
    $parent = get_term( $term->parent, $term->taxonomy );
    
    if ( is_wp_error( $parent ) )
        return $parents;
    
    $parents[] = $parent;
    if ( $parent->parent )
        get_term_parents( $parent, $parents );
    return $parents;
}




// fixes bug where we get a 404 on the last page when viewing tags
// http://127.0.0.1/chemsec/tag/fisk/page/3/
// I guess is that it's because publication is never calculated in the pagination 
// but in the number of pages since it's added after
function request_function( $query_vars ){

    if( isset( $query_vars['tag'] ) && isset( $query_vars['paged'] ) ) {
        $query_vars['post_type'] = array( 'post', 'publication' );
    }

    return $query_vars;
}

function custom_password_form( $output ) {
    global $post;
    // $post = get_post( $post );
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
        <p>' . __( 'This content is password protected. To view it please enter your password below:' ) . '</p>
        <table>
            <tr>
                <td><label for="' . $label . '"><span class="screen-reader-text">' . __( 'Password:' ) . '</span><input placeholder="' . __( 'Password:' ) . '" name="post_password" id="' . $label . '" type="password" size="20" /></label></td>
                <td><input type="submit" name="Submit" value="' . esc_attr__( 'Submit' ) . '" /></td>
            </tr>
        </table>
    <p></p></form>
    ';

    return $output;
}
