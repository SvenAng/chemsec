<?php
global $first_post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    $files = get_field('files');
    if($files) {
        $post_url = $files[0]['file']['url'];
    } else {
        $post_url = get_permalink();
    }
    ?>

    <div class="row">
        <?php
        if( !has_post_thumbnail() ) {
            $class = 'col-xs-12';
        } else {
            $class = 'col-xs-12 col-sm-6';
        }
        ?>
        <div class="<?php echo $class; ?>">
            <?php if( has_post_thumbnail() ): ?>
            <a class="post-thumbnail" href="<?php echo get_permalink(); ?>" aria-hidden="true">
                <?php
                    $thumbnail_size = $first_post ? 'new-publication' : 'new-publication';
                    the_post_thumbnail( $thumbnail_size, array( 'alt' => get_the_title() ) );
                ?>
            </a>
            <?php endif; ?>
        </div>

        <div class="<?php echo $class; ?>">

            <header class="entry-header">
                <?php
                if ( ! get_acf( 'settings-hide-title' ) ):
                    the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
                endif;
                ?>
            </header>

            <div class="entry-content">
                <?php
                    the_content();
                ?>
            </div>

            <?php
            $files = get_field('files');
            if( $files && !post_password_required() ): ?>
                <div class="entry-files">
                    <ul>
                    <?php
                    foreach ($files as $file) {
                        $title = $file['title'];
                        $url = $file['file']['url'];
                        echo '<li><a href="'.$url.'" target="_blank">'.$title.' &gt;</a></li>';
                    }
                    ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="entry-footer">
                <?php get_template_part( 'templates/parts/content', 'tags' ); ?>
            </div>
        </div>

    </div>

</article>
