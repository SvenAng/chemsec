<?php
/*
 * custom-functions.php
 * Is a file that contains website specific functions.
 * Functions that will not work on any other website and often do very specific stuff
 * This file will most often be cleaned for each website.
 */

function get_chemsec_posts( $tags ) {
    $publication_tax_query = array('relation' => 'AND');
    $business_tool_tax_query = array('relation' => 'AND');
    $post_tax_query = array('relation' => 'AND');

    foreach ($tags as $tag) {
        $publication_tax_query[] = array(
            'taxonomy' => 'publication_tag',
            'field'    => 'slug',
            'terms'    => $tag,
        );
        $business_tool_tax_query[] = array(
            'taxonomy' => 'business-tool_tag',
            'field'    => 'slug',
            'terms'    => $tag,
        );
        $post_tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => $tag,
        );
    }

    $args = array(
        'posts_per_page' => '-1',
        'post_status' => 'publish'
    );

    $post_query = new WP_Query( array_merge( $args, array(
        'post_type' => 'post',
        'tax_query' => $post_tax_query
    )));
    $publication_query = new WP_Query( array_merge( $args, array(
        'post_type' => 'publication',
        'tax_query' => $publication_tax_query
    )));
    $business_tool_query = new WP_Query( array_merge( $args, array(
        'post_type' => 'business-tool',
        'tax_query' => $business_tool_tax_query
    )));


    $posts = array_merge( $post_query->posts, $publication_query->posts, $business_tool_query->posts );

    return $posts;
}

function is_tag_page() {
    if(
        get_query_var('tag') &&
        get_query_var('publication_tag') &&
        get_query_var('business-tool_tag')
    ) {
        return true;
    } else {
        return false;
    }
}

function print_persons( $persons, $address = false ) { ?>

    <table class="persons">

        <thead class="persons-head">
        
            <tr>
                <th></th>
                <th></th>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($persons as $person): ?>
            
                <tr>
                    <td class="td-image"><?php get_acf($person['picture'], array('echo' => true, 'size' => 'thumbnail')); ?></td>
                    <td>
                    <p><span class="persons-title"><?php _e('Name'); ?></span><br><?php echo $person['name']; ?></p>
                    <p><span class="persons-title"><?php _e('Phone'); ?></span><br><a href="tel:<?php echo simplify_phone_number($person['phone']); ?>"><?php echo $person['phone']; ?></a></p>
                    <p><span class="persons-title"><?php _e('Email'); ?></span><br><a href="mailto:<?php echo encode_email($person['email']); ?>"><?php echo encode_email($person['email']); ?></a></p>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

    <?php
}

function print_groups( $groups ) {

    echo '<div class="groups">';

    $index = 0;
    foreach ($groups as $group) {
        
        if( $index % 2 == 0 ) {
            echo '<div class="row">';
        }

        echo '<div class="col-sm-6">';

            echo '<div class="group">';

                echo '<div class="group-title">'.$group['group_name'].'</div>';

                print_persons( $group['persons'] );

            echo '</div>';

        echo '</div>';

        if( $index % 2 == 1 ) {
            echo '</div>';
        }

        $index++;

    }

    echo '</div>';
}

function wp_get_custom_pages( $post_type ) {

    echo '<div class="sidebar-menu">';
    echo '<ul>';

    $depth = is_post_type_archive( $post_type ) ? 1 : 0;

    $depth = $post_type == 'publication' ? 1 : $depth;

    $args = array(
        'title_li' => '',
        'show_home' => 1,
        'post_type' => $post_type,
        'depth' => $depth
    );

    wp_list_pages($args);

    echo '</ul></div>';

}

function oAuth() {
    // Step 1: Encode consumer key and secret
    $consumer_key = 'd2E8HATmQHReIqzxNA2I1onFH';
    $consumer_secret = 'whYFiaDNl5W1PGnxvq7CC89QGdIbAYPFsthaOadco9DiQyPSp7';
    $bearer_token_credentials = base64_encode( rawurlencode($consumer_key) . ':' . rawurlencode($consumer_secret) );


    // Step 2: Obtain a bearer token
    $url = 'https://api.twitter.com/oauth2/token';

    $post_data = array(
        'grant_type' => 'client_credentials'
    );

    $options = array(
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '.$bearer_token_credentials
        )
    );

    $result = curl_fetch($url, $post_data, $options);
    $bearer_token = json_decode($result);
    $bearer_token = $bearer_token->access_token;

    return $bearer_token;
}

function get_tweets() {

    $bearer_token = oAuth();

    $screen_name = 'chemsec';
    $url = 'https://api.twitter.com/1.1/users/show.json?screen_name='.$screen_name;

    $options = array(
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$bearer_token
        )
    );

    $tweets_json = curl_fetch( $url, array(), $options );
    $tweets = json_decode($tweets_json);

    return $tweets;
}
?>