<?php get_header(); ?>

    <div class="container">

        <div id="content" class="site-content">

            <header class="content-header">
                <?php if(is_archive()):
                    the_archive_title( '<h2 class="page-title">', '</h2>' );
                elseif ( ! get_acf( 'settings-hide-title' ) ): ?>
                    <h2 class="page-title"><?php single_post_title(); ?></h2>
                <?php endif; ?>
            </header>

            <?php
            if ( have_posts() ) {

                while ( have_posts() ) {

                    the_post();

                    get_template_part( 'templates/parts/content', 'page' );

                }

            } else {

                get_template_part( 'content', 'none' );

            }
            ?>

            <footer class="content-footer">
                <?php paging_navigation(); ?>
            </footer>

        </div>

    </div>

<?php get_footer(); ?>