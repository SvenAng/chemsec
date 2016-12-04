<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
        <?php
            the_post_thumbnail( 'business-tool', array( 'alt' => get_the_title(), 'class' => 'a3-notlazy' ) );
        ?>
    </a>

    <div class="entry-content">
        <?php
            the_excerpt();
        ?>
    </div>

    <a class="read-more black-button" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>

</article>
