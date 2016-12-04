<?php

$append = '';
$form = false;
$serach_query = get_search_query();

if( ( is_tax('tag') || is_tax('business-tool_tag') || is_tax('publication_tag') ) || is_tag() || get_query_var('tag', false) ) {
    global $wp_query;
    $post_type = get_post_type();
    $post_type_object = get_post_type_object($post_type);
    
    $post_type = $post_type_object->labels->name;
    $title = sprintf(__('%s keywords', THEME_DOMAIN), $post_type);
} 

elseif( is_search() && ! empty( $serach_query ) ) {
    $title = sprintf( __( 'Search Results for: %s', THEME_DOMAIN ), get_search_query() );
    $url = '';
    $form = true;
}

elseif(!is_page()) {

    $post_type = @$wp_query->query['post_type'] ? $wp_query->query['post_type'] : 'post';

    $taxonomy = get_queried_object()->taxonomy;
    
    if( strpos( $taxonomy, 'publication') !== false) {
        $post_type = 'publication';
    }

    $post_type_object = get_post_type_object( $post_type );

    if( $post_type_object ) {

        if( $post_type == 'post') {
            $url = get_permalink( get_option( 'page_for_posts' ) );
        } else {
            $url = get_post_type_archive_link( $post_type );
        }
        
        $title = $post_type_object->label;

    }
}
if (is_year()) :

    $append .= ' / ' . get_the_date( 'Y' );

endif;
?>

<?php if( @$title ): ?>
     <!-- Shows Tools instead of Business Tools -->
    <?php if( $post_type =='business-tool' ){
            $title = 'Tools';
    } 
    ?>
    <header class="content-header">
        
        <h2 class="page-title">
            <?php if( @$url ): ?>
                <a href="<?php echo $url; ?>">
            <?php endif; ?>
            <?php echo $title; ?>
            <?php if( @$url ): ?>
                </a>
            <?php endif; ?><?php echo $append; ?>
        </h2>

    </header>

    <?php if ( $form ): 
        get_template_part('searchform');
    ?>
    
    <?php endif;?>
<?php endif; 

global $back_url;
$back_url = $url;

?>