<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php
            entry_meta(array('categories' => false, 'tags' => false, 'comments' => false, 'updated' => false, 'author' => false));
            the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
        ?>
    </header>

    <div class="entry-content">
        <?php
            the_excerpt();
        ?>
    </div>

    <a class="read-more black-button" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>

</article>
