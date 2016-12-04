<div id="header-banner">
    <?php

    the_post_thumbnail( 'front-page-header' );

    ?>

    <div id="header-banner-content-wrapper">
        <div class="container" id="header-banner-content">  
            <div class="col-xs-12">
                <?php
                $header_text_color = get_field('header_text_color');
                echo '<style>#header-banner-content { color: #'.$header_text_color.'; }</style>';
                echo get_field('header_text');
                ?>
                <div class='front_2'>
                    <?php echo get_field('header_text_2'); ?>
                </div>
                <?php
                $buttons = get_field('header_buttons');
                foreach ($buttons as $button) {
                    echo '<a class="chemsec-button" href="'.$button['link'].'">'.$button['title'].'</a>';
                }
                ?>
            </div>
        </div>
    </div>  
</div>