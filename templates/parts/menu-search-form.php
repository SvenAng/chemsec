<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="submit" class="search-submit icon-search" value="&#xe803;" />
    <label>
        <span class="screen-reader-text"><?php _ex( 'Search for:', 'label' ); ?></span>
        <input type="search" class="search-field" autocomplete="off" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ); ?>" />
    </label>
</form>