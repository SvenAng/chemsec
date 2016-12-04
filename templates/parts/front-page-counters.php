<?php
$counters = get_field('counters', get_option('page_on_front'));

global $counter;
if($counters) {
    foreach ($counters as $counter) {
        get_template_part( 'templates/parts/content', 'counter' );
    }

} else {

    get_template_part( 'templates/parts/content', 'none' );

}
?>