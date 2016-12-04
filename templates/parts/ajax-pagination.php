<?php
global $wp_query;
$page = get_query_var('paged');
$pages = $wp_query->max_num_pages;

// Don't print empty markup if there's only one page.
if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
    return;
}

// Don't show on last page
if($page != $pages):
?>
<footer class="ajax-pagination content-footer">
    <div class="nav-next text-right"><?php next_posts_link( __('Load more posts', THEME_DOMAIN).'<span class="icon"></span>' ); ?></div>
</footer>
<?php
endif;
?>