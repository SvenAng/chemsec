<?php
global $first_post;

$args = array(
    'post_parent' => $post->ID,
    'post_type'   => 'publication',
    'post_status' => 'publish' 
);

$children = get_children( $args );




$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => 8 ) );
query_posts( $args );
?>
adsadsads
<div id="publications">

    <div id="latest-publication" class="row">

        <div class="col-xs-12">

            <?php
            $post = array_values($children)[0];
            setup_postdata( $post );
            $first_post = true;
            get_template_part( 'templates/parts/content', 'publication' );
            ?>

        </div>

    </div>

    <div id="all-publications" class="row">

        <div class="col-xs-12">

            <header class="content-header">
                <h2 class="page-title"><?php printf(__('All publications about %s'), single_post_title('', false)); ?></h2>
            </header>

            <?php
            array_shift($children);
            $index = 0;
            foreach ($children as $post) {

                if( $index % 3 == 0 ) {
                    echo '<div class="row">';
                }

                setup_postdata( $post );
                $first_post = false;

                echo '<div class="col-sm-4">';
                get_template_part( 'templates/parts/content', 'publication' );
                echo '</div>';

                if( $index % 3 == 2 ) {
                    echo '</div>';
                }

                $index++;
            }
            ?>

        </div>

    </div>

</div>