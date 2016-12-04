<?php

// Define constants since they are superglobal
define('THEME_DOMAIN', 'chemsec');
define('THEME_NAME', 'ChemSec');
define('TEMPLATE_DIRECTORY', get_template_directory());
define('TEMPLATE_DIRECTORY_URI', get_template_directory_uri()); // we'll use get_template_directory_uri instead of get_stylesheet_directory_uri since get_stylesheet_directory_uri will return the childtheme dir
define('TEMPLATE_CSS_DIRECTORY_URI', TEMPLATE_DIRECTORY_URI . '/includes/css' );
define('TEMPLATE_JS_DIRECTORY_URI', TEMPLATE_DIRECTORY_URI . '/includes/js' );
define('TEMPLATE_IMG_DIRECTORY_URI', TEMPLATE_DIRECTORY_URI . '/includes/img' );


// Helper Classes / functions
require_once(TEMPLATE_DIRECTORY.'/includes/functions/helper-functions.php');
require_once(TEMPLATE_DIRECTORY.'/includes/functions/wp-functions.php');
require_once(TEMPLATE_DIRECTORY.'/includes/functions/custom-functions.php');
require_once(TEMPLATE_DIRECTORY.'/includes/functions/admin-settings.php');
require_once(TEMPLATE_DIRECTORY.'/includes/functions/widgets.php');
require_once(TEMPLATE_DIRECTORY.'/includes/functions/hook-functions.php');

// Config stuff - This should probably be moved to another file
define('DISALLOW_FILE_EDIT', true);         // Disable file editing in theme options
remove_action('wp_head', 'wp_generator');   // Remove wordpress version meta
remove_action('wp_head', 'woo_version');    // Remove woocommerce version meta
// Remove emojis
add_action( 'init', function() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', function( $plugins ) {
        return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
    });
});



// Wordpress init
add_action( 'init', 'init_function', 10 );

// Admin menu
add_action( 'admin_menu', 'admin_menu_function' );

// Wordpress after setup theme
add_action( 'after_setup_theme', 'after_setup_theme_function', 10 );

// Theme scripts and styles
add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_function', 10 );

add_filter( 'wp_nav_menu_objects', 'get_menu_item_parent_id' );

add_filter( 'excerpt_length', 'set_excerpt_length' );

add_filter( 'excerpt_more', 'set_excerpt_more' );

// Custom permalink for custom post
add_action( 'wp_loaded', 'wp_loaded_function' );

add_action( 'post_type_link', 'post_type_link_function', 10, 2 );

// add_filter( 'term_link', 'term_link_function', 10, 2 );

// Fix Tag last page 404
add_filter( 'request', 'request_function' );

add_filter( 'the_password_form', 'custom_password_form' );