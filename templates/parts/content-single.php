<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>

    <?php if(!is_page()): ?>
    <header class="entry-header">

        <div class="entry-image">
        <?php
            the_post_thumbnail( 'single-post', array( 'alt' => get_the_title() ) );
        ?>
        </div>

        <?php
            $post_year = mysql2date("Y", $post->post_date_gmt);
            $post_month = mysql2date("F", $post->post_date_gmt);
        ?>

        <?php if( get_post_type() == 'post'): ?> 
            <h2 class="page-title"><?php printf(__('News %s / %s', THEME_DOMAIN), $post_year, $post_month); ?></h2>
            <?php
                entry_meta(array('categories' => false, 'tags' => false, 'comments' => false, 'updated' => false, 'author' => false));
                // TODO check this condition, SÄ
                if ( get_post_type() != 'business-tool' && ! get_acf( 'settings-hide-title' ) ) : 
                    the_title( sprintf( '<h4 class="entry-title">', esc_url( get_permalink() ) ), '</h4>' );
                endif;
            ?>    
        <?php endif; ?>
        
    </header>
    <?php endif; ?>

    <div class="entry-content">
        <?php
            the_content();
        ?>
    </div>

    <?php
    $files = get_field('files');
    if($files && !post_password_required()): ?>
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

        <?php if( $tool_link_url = get_field('tool_link_url') ):
            $target = get_field('tool_link_target') ? 'target="_blank"' : '';
        ?>
            <a class="tool-link black-button" <?php echo $target; ?> href="<?php echo $tool_link_url; ?>"><?php echo get_field('tool_link_title'); ?></a>
        <?php endif; ?>

    </div>

    <div class="entry-footer">
        <?php get_template_part( 'templates/parts/content', 'tags' ); ?>
    </div>

</article>
