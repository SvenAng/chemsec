<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="row">

    <div class="col-xs-4">
        
        <div class="entry-image">
            
            <?php the_post_thumbnail( 'single-post', array( 'alt' => get_the_title() ) ); ?>

        </div>

    </div>

    <div class="col-xs-8">

        <header class="entry-header">
            <?php
                the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
                entry_meta(array('categories' => false, 'comments' => false, 'updated' => false, 'author' => false));
            ?>
        </header>

        <div class="entry-content">
            <?php
                the_excerpt();
            ?>
        </div>

    </div>

    </div>

    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read This Publication &gt;&gt;'); ?></a>

</article>