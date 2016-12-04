<div id="footer-contact">
    <h4><?php _e('Contact'); ?></h4>
    <?php
    $contacts = get_field('contact', 'option');

    if($contacts) {
        
        echo '<table>';
        foreach ($contacts as $key => $contact):
            $type = $contact['type'];
            $title = $contact['title'];
            $value = $contact['value'];
            $url = $value;

            switch ($type) {
                case 'email': $url = 'mailto:'.encode_email($value); break;
                case 'phone': $url = 'tel:'.simplify_phone_number($value); break;
            }
            ?>
            <tr>
                <td><?php echo $title; ?></td>
                <td><a href="<?php echo $url; ?>"><?php echo $value; ?></a></td>
            </tr>
        <?php endforeach;
        echo '</table>';

    } else {

        get_template_part( 'templates/parts/content', 'none' );

    }
    ?>
</div>