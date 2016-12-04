<?php
/**
 *
 * Template Name: Contact
 *
 */

get_header();
?>

    <div class="container">

        <div id="content" class="site-content">

            <header class="content-header">
                <?php if(is_archive()):
                    the_archive_title( '<h2 class="page-title">', '</h2>' );
                else: ?>
                    <h2 class="page-title"><?php single_post_title(); ?></h2>
                <?php endif; ?>
            </header>

            <?php get_template_part( 'templates/parts/contact', 'address' ); ?>

            <div class="main">
                <div class="row">

                    <div class="col-xs-12 col-sm-6">
                        <?php get_template_part( 'templates/map' ); ?>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <?php while ( have_posts() ) : the_post();

                            get_template_part( 'templates/parts/content', 'page' );

                        endwhile; ?>
                    </div>

                </div>
            </div>

            <?php
            $groups = get_field('group');
            print_groups($groups);
            ?>

            <footer class="content-footer">
                <?php paging_navigation(); ?>
            </footer>

        </div>

    </div>

<?php get_footer(); ?>
