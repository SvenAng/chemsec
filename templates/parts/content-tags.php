<?php
$taxanomy = get_post_type() .'_tag';
$tags = wp_get_post_terms( $post->ID, $taxanomy );
$count = count($tags);
if ($tags && is_array($tags)) {
    echo '<div class="tags">';

    echo '<h4>'.__('Keywords').'</h4>';

    if( !is_single() ) {
        echo ': ';
    }

    $index = 1;
    foreach($tags as $tag) {
        // $post_type = get_post_type();
        // $url = esc_url( add_query_arg( array('post_type' => $post_type), get_tag_link($tag->term_id) ) );
        echo '<a class="tag" href="'.get_term_link($tag).'">'.$tag->name.'</a>';

        if( !is_single() && $index < $count ) {
            echo ', ';
        }

        $index++;
    }
    echo '</div>';
}
?>