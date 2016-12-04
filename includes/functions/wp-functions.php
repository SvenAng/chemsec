<?php
/*
 * wp-functions.php
 * Is a file that contains generic functions that often are an extensions of wordpress functions
 * or a merge of wordpress functions. For example get_post_thumbnail
 */

function post_has_children( $post_id = false, $post_type = false ) {

    // get post type if not provided
    $post_type = !$post_type ? get_post_type() : $post_type;
    $post_id = !$post_id ? $post->ID : $post_id;

    $args = array(
        'post_type' => $post_type,
        'post_parent' => $post_id
    );

    $children = get_posts($args);

    if( count( $children ) > 0 ) {
        return true;
    } else {
        return false;
    }
}

function paging_navigation() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links( array(
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $GLOBALS['wp_query']->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => __( 'Previous', THEME_DOMAIN ),
        'next_text' => __( 'Next', THEME_DOMAIN ),
    ) );

    if ( $links ) {
        echo '<nav class="navigation paging-navigation pagination loop-pagination" role="navigation">'.$links.'</nav>';
    }
}

function wp_get_hierarchical_archives() {
    global $wpdb, $wp_locale;

    $last_changed = wp_cache_get( 'last_changed', 'posts' );
    if ( ! $last_changed ) {
        $last_changed = microtime();
        wp_cache_set( 'last_changed', $last_changed, 'posts' );
    }
    
    $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";

    $key = md5( $query );
    $key = "wp_get_archives:$key:$last_changed";
    if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
        $results = $wpdb->get_results( $query );
        wp_cache_set( $key, $results, 'posts' );
    }

    if ( $results ) {
        // group by year
        $dates = array();
        foreach($results as $key => $result) {
           $dates[$result->year][$key] = $result;
        }

        echo '<ul class="years">';
        foreach( $dates as $year => $date_years ) {
            $year_url = get_year_link( $year );

            $query_year = get_query_var('year');
            $is_current_archive_item = $year == $query_year ? 'current_archive_item' : '';

            echo '<li class="year '.$is_current_archive_item.'">';
            echo '<a href="'.$year_url.'">'.__( $year, THEME_DOMAIN ).'</a>';

            if ( $date_years && $year == $query_year ) {
                echo '<ul class="months">';
                foreach ( $date_years as $key => $date_months ) {
                    $month = $date_months->month;
                    $month_title = $wp_locale->get_month( $month );
                    $month_url = get_month_link( $year, $month );

                    $monthnum = get_query_var('monthnum');
                    $is_current_archive_item = $month == $monthnum ? 'current_archive_item' : '';

                    echo '<li class="month '.$is_current_archive_item.'"><a href="'.$month_url.'">'.__( $month_title, THEME_DOMAIN ).'</a></li>';

                }
                echo '</ul>';
            }

            echo '</li>';
        }
        echo '</ul>';
    }

}

function entry_meta($options = array()) {

    extract($options);


    if ( @$sticky !== false && is_sticky() && is_home() && ! is_paged() ) {
        printf( '<span class="sticky-post">%s</span>', __( 'Featured', THEME_DOMAIN ) );
    }

    $format = get_post_format();
    if ( current_theme_supports( 'post-formats', $format ) ) {
        printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
            sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentyfifteen' ) ),
            esc_url( get_post_format_link( $format ) ),
            get_post_format_string( $format )
        );
    }

    if ( @$date !== false ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

        if ( $updated !== false && get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            get_the_date(),
            esc_attr( get_the_modified_date( 'c' ) ),
            get_the_modified_date()
        );

        printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
            _x( 'Posted on', 'Used before publish date.', 'twentyfifteen' ),
            esc_url( get_permalink() ),
            $time_string
        );
    }

    if ( 'post' == get_post_type() ) {
        if ( $author !== false && ( is_singular() || is_multi_author() ) ) {
            printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
                _x( 'Author', 'Used before post author name.', 'twentyfifteen' ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author()
            );
        }

        $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
        if ( $categories !== false && $categories_list ) {
            printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                _x( 'Categories', 'Used before category names.', 'twentyfifteen' ),
                $categories_list
            );
        }

        $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
        if ( $tags !== false && $tags_list ) {
            printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                _x( 'Tags', 'Used before tag names.', 'twentyfifteen' ),
                $tags_list
            );
        }
    }

    if ( is_attachment() && wp_attachment_is_image() ) {
        // Retrieve attachment metadata.
        $metadata = wp_get_attachment_metadata();

        printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
            _x( 'Full size', 'Used before full size attachment link.', 'twentyfifteen' ),
            esc_url( wp_get_attachment_url() ),
            $metadata['width'],
            $metadata['height']
        );
    }

    if ( $comments !== false && ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link( __( 'Leave a comment', THEME_DOMAIN ), __( '1 Comment', THEME_DOMAIN ), __( '% Comments', THEME_DOMAIN ) );
        echo '</span>';
    }
}