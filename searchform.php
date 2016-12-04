<?php

if ( isset( $_GET['post_type'] ) ){
    $custom_search = $_GET['post_type'];
}

if (get_post_type() == 'publication' && is_archive() || is_singular( 'publication' )) {
    $custom_search = 'publication';
    $placeholder = __('Search Publications', THEME_DOMAIN);
} elseif( is_post_type_archive( 'business-tool' ) || is_singular( 'business-tool' ) || is_category( ) ) {
    $custom_search = 'business-tool';
    $placeholder = __('Search Business Tools', THEME_DOMAIN);
} elseif(get_post_type() == 'post' && is_archive() || is_singular( 'post' )|| is_singular() || is_home()){    
    $custom_search = 'post';
    $placeholder = __('Search News', THEME_DOMAIN);
} else {
    $placeholder = esc_attr_x( 'Search &hellip;', 'placeholder' );
}
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <table>
        <tr>
            <td class="search-field-column">
                <label>
                    <?php if(@$custom_search): ?>
                        <input type="hidden" name="post_type" value="<?php echo $custom_search; ?>" />
                    <?php endif; ?>
                    <span class="screen-reader-text"><?php _ex( 'Search for:', 'label' ); ?></span>
                    <input type="search" class="search-field" autocomplete="off" placeholder="<?php echo $placeholder; ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ); ?>" />
                </label>
            </td>
            <td class="search-button-column">
                <input type="submit" class="search-submit" value="Search" />
            </td>
        </tr>
    </table>
</form>