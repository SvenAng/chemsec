<?php get_header(); ?>

    <div id="content" class="site-content">
    
        <div class="block">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-sm-8">
                        <?php get_template_part( 'templates/parts/front-page', 'latest-news' ); ?>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <?php get_template_part( 'templates/parts/front-page', 'news-archive' ); ?>
                    </div>

                </div>
                
            </div>

        </div>


        <div id="business-tools" class="block">

            <div class="container">

                <?php get_template_part( 'templates/parts/front-page', 'business-tools' ); ?>
                
            </div>

        </div>


        <div id="business-group" class="block">

            <div class="container">

                <?php get_template_part( 'templates/parts/front-page', 'business-group' ); ?>
                
            </div>

        </div>


        <div id="counters" class="block">

            <div class="container">

                <div class="row">

                    <?php get_template_part( 'templates/parts/front-page', 'counters' ); ?>

                </div>
                
            </div>

        </div>

    </div>


<?php get_footer(); ?>
