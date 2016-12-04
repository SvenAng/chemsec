<?php

$social_media_buttons = get_field('social-media-buttons', 'option');

if($social_media_buttons) {

    echo '<div class="social-links">';
        echo '<ul>';
        foreach ($social_media_buttons as $social_media_button) {
            $link = $social_media_button['link'];
            $name = $social_media_button['icon'];

            switch ($name) {
                case 'facebook':
                    $title = 'Facebook';
                    $icon = '&#xe802;';
                    break;
                case 'twitter':
                    $title = 'Twitter';
                    $icon = '&#xe806;';
                    break;
                case 'googleplus':
                    $title = 'Google+';
                    $icon = '&#xe804;';
                    break;
                case 'linkedin':
                    $title = 'LinkedIn';
                    $icon = '&#xe805;';
                    break;
                case 'instagram':
                    $title = 'Instagram';
                    $icon = '&#xe801;';
                    break;
                case 'youtube':
                    $title = 'YouTube';
                    $icon = '&#xe808;';
                    break;
                case 'rss':
                    $title = 'RSS';
                    $icon = '&#xe807;';
                    break;
            }

            echo '<li class="social-link"><a class="icon-'.$name.'" target="_blank" title="'.$title.'" href="'.$link.'">'.$icon.'</a></li>';
        }
        echo '</ul>';
    echo '</div>';

} else {

    get_template_part( 'templates/parts/content', 'none' );

}

?>