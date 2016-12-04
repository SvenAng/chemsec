
<?php

global $back_url;

if(get_post_type()) {
    $taxanomy = get_post_type() .'_tag';
    $all_tags = get_terms( $taxanomy );
} else {
    $all_tags = get_terms( array(
        'business-tool_tag',
        'publication_tag',
        'post_tag'
    ) );
}

// take out the slug 
$as = array();
foreach ($all_tags as $key => $tag) {
    $as[$tag->term_id] = $tag->slug;
}

// make a unique array 
$unique_tags = array_unique($as);
// get the keys, term_id
$unique_tag_keys = array_keys($unique_tags);

// get all tags that has a term_id in the array
$tags = array();
foreach ($all_tags as $key => $tag) {
    if(in_array($tag->term_id, $unique_tag_keys)) {
        $tags[] = $tag;
    }
}

$selected_tags = $wp_query->query['tag'];
$selected_tags = empty($selected_tags) ? $wp_query->query['publication_tag']   : $selected_tags;
$selected_tags = empty($selected_tags) ? $wp_query->query['business-tool_tag'] : $selected_tags;

$selected_tags = preg_split('[,|\+]', $selected_tags);

if ($tags) {
    echo "<p></p><div class=leftmenu-strong>Filter by category</div>";
    echo '<p></p><div data-url="'.get_site_url().'" class="tags">';

    foreach($tags as $tag) {
        
        $selected = in_array($tag->slug, $selected_tags) ? 'selected' : '';

        if(!get_post_type()) {
            $url = get_site_url() . '/keyword/' . $tag->slug .'/';
        } else {
            $url = get_tag_link($tag->term_id);
        }

        echo '<a class="tag '.$selected.'" data-taxonomy="'.$tag->taxonomy.'" data-slug="'.$tag->slug.'" href="'.$url.'">'.$tag->name.'</a>';

    }
    echo '</div>';
}


?>

<?php if( ! empty( $back_url ) && $back_url != get_current_url() ): ?>
    <a href="<?php echo $back_url; ?>" class="back-link"><?php _e('Go back'); ?></a>
<?php endif; ?>
<?php //if( ! empty( $back_url ) && $back_url != get_current_url() ): ?>
    <a href="." class="back-link reset-link"><?php _e('Reset'); ?></a>
<?php //endif; ?>