<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">  
        <?php
            the_post_thumbnail( 'business-tool-large', array( 'alt' => get_the_title() ) );
        ?>
    </a>

    <header class="entry-header">
        <?php
            if ( ! get_acf( 'settings-hide-title' ) ) : 
                the_title( sprintf( '<h4 class="entry-title">', esc_url( get_permalink() ) ), '</h4>' );
            endif;
        ?>
    </header>

    <div class="entry-content">
        <?php
            the_excerpt();
        ?>
    </div>

    <div class="entry-footer">

        <?php if( $tool_link_url = get_field('tool_link_url') ):
            $target = get_field('tool_link_target') ? 'target="_blank"' : '';
        ?>
            <a class="tool-link black-button" <?php echo $target; ?> href="<?php echo $tool_link_url; ?>"><?php echo get_field('tool_link_title'); ?></a>
        <?php endif; ?>

        <a class="read-more black-button" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>

    </div>

</article>
