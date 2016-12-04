<?php
$address = get_field('address');
$address = $address[0];
?>

<div class="groups">
    <div class="group">
        <div class="group-subtitle"><?php echo $address['name']; ?></div>

        <div class="row">

            <div class="col-xs-12 col-sm-6">
            
                <table class="persons">
                
                    <tr>
                        <th><?php _e('Address'); ?></th>
                        <td><?php echo $address['address']; ?></td>
                    </tr>
                    
                    <tr>
                        <th><?php _e('Phone'); ?></th>
                        <td><a href="tel:<?php echo simplify_phone_number($address['phone']); ?>"><?php echo $address['phone']; ?></a></td>
                    </tr>
                    
                    <tr>
                        <th><?php _e('Email'); ?></th>
                        <td><a href="mailto:<?php echo encode_email($address['email']); ?>"><?php echo encode_email($address['email']); ?></a></td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>