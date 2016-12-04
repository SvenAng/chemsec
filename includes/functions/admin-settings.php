<?php

// Add custom page for site specific settings
if( function_exists( 'acf_add_options_page' ) && current_user_can( 'manage_options' ) ) {

    acf_add_options_sub_page(array(
        'page_title'    => __( 'Footer', THEME_DOMAIN ),
        'menu_title'    => __( 'Footer', THEME_DOMAIN ),
        'parent_slug'   => sprintf( __( 'themes.php', THEME_DOMAIN ), THEME_NAME ),
    ));
    
}

?>