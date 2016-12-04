<?php
    if( has_post_thumbnail() ){
        $publicationListClassLeft = "col-xs-12 col-sm-4";
        $publicationListClassRight = "col-xs-12 col-sm-8";
    }else{
        $publicationListClassRight = "col-xs-12 col-sm-12";
    }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <?php if( has_post_thumbnail() ): ?>
            <div class="<?php print $publicationListClassLeft; ?>">
                
            <a class="post-thumbnail" href="<?php echo get_permalink(); ?>" aria-hidden="true">
                <?php
                    // $thumbnail_size = $first_post ? 'publication' : 'publication';
                    // the_post_thumbnail( $thumbnail_size, array( 'alt' => get_the_title() ) );
                the_post_thumbnail( 'publication-list', array( 'alt' => get_the_title() ) );
                ?>
            </a>
                
            </div>
        <?php endif; ?>    
        <div class="<?php print $publicationListClassRight; ?>">
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

            <div class="entry-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <?php get_template_part( 'templates/parts/content', 'tags' ); ?>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="read-more black-button" href="<?php the_permalink(); ?>"><?php _e('Read more'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</article>
