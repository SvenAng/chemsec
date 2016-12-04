<?php
/*
 * widgets.php
 * Is a file that contains custom widgets
 * This file should also be quite clean and call functions from custom-functions.php
 */


add_action('widgets_init', function() {
    register_widget('Widget_CF7');
    register_widget('Widget_BLLT_Donate');
});



class Widget_BLLT_Donate extends WP_Widget {

    function Widget_BLLT_Donate() {
        $widget_ops = array( 'description' => __( "Add Swish and PayPal donate buttons to your page") );
        $this->WP_Widget('bllt_donate', __('Donate Buttons'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = $instance['title'];
        $widget_id = 'widget-' . $this->id_base . '-' . $this->number;  
     
        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        ?>
        <p><?php echo $instance['text']; ?></p>

        <a class="orange-button donate-button" href="#"><?php echo $instance['button_title']; ?></a>

        <div class="donate-buttons">

            <?php if(!empty($instance['swish'])): ?>
                <div class="swish">
                    <h4 class="donate-title"><?php echo $instance['swish_title']; ?></h4>
                    <p><?php echo $instance['swish_text']; ?></p>
                    <div class="code"><?php echo $instance['swish']; ?></div>
                </div>
            <?php endif; ?>

            <?php if(!empty($instance['hosted_button_id'])): ?>
                <div class="paypal">
                    <h4 class="donate-title"><?php echo $instance['paypal_title']; ?></h4>
                    <p><?php echo $instance['paypal_text']; ?></p>

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="<?php echo $instance['hosted_button_id']; ?>">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <?php /* <input type="submit" border="0" name="submit" value="<?php echo $instance['button_value']; ?>"> */ ?>
                        <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {

        // $instance = wp_parse_args( (array) $instance, array( 'lc' => 'SE' ) );
        // $instance = wp_parse_args( (array) $instance, array( 'currency_code' => 'SEK' ) );
        $instance = wp_parse_args( (array) $instance, array( 'title' => false ));
        $instance = wp_parse_args( (array) $instance, array( 'button_value' => false ));

        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>

            <p><label for="<?php echo $this->get_field_id('button_title'); ?>"><?php _e('Button title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('button_title'); ?>" name="<?php echo $this->get_field_name('button_title'); ?>" value="<?php echo esc_attr( $instance['button_title'] ); ?>" />
            </p>

            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:') ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_attr( $instance['text'] ); ?></textarea>
            </p>

            <h4>Swish</h4>

            <p><label for="<?php echo $this->get_field_id( 'swish_title' ); ?>"><?php _e( 'Title:' ) ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'swish_title' ); ?>" name="<?php echo $this->get_field_name( 'swish_title' ); ?>" value="<?php echo esc_attr( $instance[ 'swish_title' ] ); ?>" />
            </p>

            <p><label for="<?php echo $this->get_field_id('swish_text'); ?>"><?php _e('Text:') ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('swish_text'); ?>" name="<?php echo $this->get_field_name('swish_text'); ?>"><?php echo esc_attr( $instance['swish_text'] ); ?></textarea>
            </p>

            <p><label for="<?php echo $this->get_field_id( 'swish' ); ?>"><?php _e( 'Swish code:' ) ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'swish' ); ?>" name="<?php echo $this->get_field_name( 'swish' ); ?>" value="<?php echo esc_attr( $instance[ 'swish' ] ); ?>" />
            </p> 

            <h4>PayPal</h4>

            <?php
                $fields = array(
                    array(
                        'id' => 'paypal_title',
                        'title' => 'Title: ',
                        'placeholder' => ''
                    ),
                    array(
                        'id' => 'paypal_text',
                        'title' => 'Text: ',
                        'placeholder' => '',
                        'type' => 'textarea'
                    ),
                    array(
                        'id' => 'hosted_button_id',
                        'title' => 'Button Id: ',
                        'placeholder' => 'A1BCDEFGHI23J4',
                        'help' => 'Log in to PayPal and <a href="https://www.paypal.com/buttons/paymentbuttons">create a donate button</a> to get an id.'
                    ),
                    array(
                        'id' => 'button_value',
                        'title' => 'Button title: ',
                        'placeholder' => 'Donate'
                    ),
                    // array(
                    //     'id' => 'item_name',
                    //     'title' => 'Organisation/service: ',
                    //     'placeholder' => 'ChemSec'
                    // ),
                    // array(
                    //     'id' => 'item_number',
                    //     'title' => 'Donation Id: ',
                    //     'placeholder' => ''
                    // ),
                    // array(
                    //     'id' => 'business',
                    //     'title' => 'Business Id (or email): ',
                    //     'placeholder' => '12A34BCDEFGHI'
                    // ),
                    // array(
                    //     'id' => 'lc',
                    //     'title' => 'Language Code: ',
                    //     'placeholder' => 'SE'
                    // ),
                    // array(
                    //     'id' => 'currency_code',
                    //     'title' => 'Currency Code: ',
                    //     'placeholder' => 'SEK'
                    // )
                );
                foreach ($fields as $key => $field):
                    $id = $field['id'];
                    $title = $field['title'];
                    $placeholder = $field['placeholder'];
                    $type = $field['type'];
                    $help = $field['help'];
                ?>
                <?php if($type == 'textarea'): ?>
                    <p><label for="<?php echo $this->get_field_id( $id ); ?>"><?php _e( $title ) ?></label>
                        <textarea placeholder="<?php echo $placeholder; ?>" class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( $id ); ?>" name="<?php echo $this->get_field_name( $id ); ?>"><?php echo esc_attr( $instance[ $id ] ); ?></textarea>
                    </p> 
                <?php else: ?>
                    <p><label for="<?php echo $this->get_field_id( $id ); ?>"><?php _e( $title ) ?></label>
                        <input placeholder="<?php echo $placeholder; ?>" type="text" class="widefat" id="<?php echo $this->get_field_id( $id ); ?>" name="<?php echo $this->get_field_name( $id ); ?>" value="<?php echo esc_attr( $instance[ $id ] ); ?>" />
                    </p> 
                <?php endif; ?>
                <?php if($help): ?>
                    <p class="help"><?php echo $help; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
                
            
        <?php
    }
}

class Widget_CF7 extends WP_Widget {


    function Widget_CF7() {
        $widget_ops = array( 'description' => __( "Widget for Contact Form 7") );
        $this->WP_Widget('custom_cf7', __('Contact Form 7'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = $instance['title'];
        $widget_id = 'widget-' . $this->id_base . '-' . $this->number;
        
     
        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
               
        ?>
        <div class="clearfix">
            <?php 
                $widget_text = empty($instance['form']) ? '' : stripslashes($instance['form']);
                echo apply_filters('widget_text','[contact-form-7 id="' . $widget_text . '"]');
            ?>
        </div>
        <?php
        
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => false ));
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
        
    <p><label for="<?php echo $this->get_field_id('form'); ?>"><?php _e('Form:') ?></label>
<?php
        $cf7posts = new WP_Query( array( 'post_type' => 'wpcf7_contact_form' ));

        if ( $cf7posts->have_posts() ) {    
            ?>
            <select class="widefat" name="<?php echo $this->get_field_name('form'); ?>" id="<?php echo $this->get_field_id('form'); ?>">
            <?php
            while( $cf7posts->have_posts() ) : $cf7posts->the_post();
                ?><option value="<?php the_id(); ?>"<?php selected(get_the_id(), $instance['form']); ?>><?php the_title(); ?></option>

                <?php
            endwhile;
        }
        else //no posts disable form
        {   ?>
            <select class="widefat" disabled>
            <option disabled="disabled">No Forms Found</option> <?php
        }
        ?>      
        </select></p> 
        <?php
    }
}