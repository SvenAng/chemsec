<?php
/*
 * helper-functions.php
 * Is a file that contains small generic functions 
 * that will work on any website, make things easier and only do one thing
 */

// a merge between var_dump and print_r
function pd() {
    $vars = func_get_args();
    
    echo '<pre>';
    
    foreach ($vars as $var){
        if(is_array($var) || is_object($var)) {
            print_r($var);
        } else {
            var_dump($var);
        }
    }
    
    echo '</pre>';
}

// A wrapper for cURL
function curl_fetch($url, $post_data = array(), $custom_options = array()){
    $ch = curl_init();

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );

    // if $post_data add post options
    if(count($post_data) > 0) {
        $post_data = array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_data
        );

        $options = $options + $post_data;
    }

    $options = $options + $custom_options;

    curl_setopt_array($ch, $options);

    $result = curl_exec($ch);

    if($result === false) {
        return 'cURL Error: ' . curl_error($ch);
    }

    curl_close($ch);

    return $result;
}

// Förenklar telefonnummer. Användbart för länkar: (href="tel:XXX")
// +46 (0)73 123 45 67  -> 046731234567
// 031 - 123 456        -> 031123456
function simplify_phone_number($phone_number) {
    // replace "-", " " and (0) with nothing
    $phone_number = str_replace(array('-', ' ', '(0)'), '', $phone_number);

    // replace "+" with 0
    $phone_number = str_replace('+', '0', $phone_number);

    return $phone_number;
}

function amf($n) { return "&#$n;"; }
function encode_email($str) {
    $str = mb_convert_encoding($str , 'UTF-32', 'UTF-8');
    $t = unpack("N*", $str);
    $t = array_map('amf', $t);
    return implode("", $t);
}

function get_retina_url( $attachment_id, $size ) {
    $site_url = get_bloginfo('url');

    // Get the attachment url
    $attachment_url = wp_get_attachment_image_src( $attachment_id, $size );
    $attachment_url = $attachment_url[0];

    $attachment_relative_filepath = str_replace($site_url, '', $attachment_url);

    $attachment_path_parts = pathinfo($attachment_relative_filepath);
    extract($attachment_path_parts);

    require_once( 'wp-admin/includes/file.php' ); // required for get_home_path()
    $path = get_home_path();
    $path = rtrim($path, '/'); // Remove trailing slash

    // Create the path to the retina image
    $retina_filename = DIRECTORY_SEPARATOR . $filename . '@2x.' . $extension;
    $attachment_retina_path = $path . $dirname . $retina_filename;

    // Check that the retina image exist before continuing
    if(file_exists($attachment_retina_path)) {

        // Create the url to the retina image
        $attachment_retina_url = $site_url . $dirname . $retina_filename;

        return $attachment_retina_url;

    } else {

        return false;

    }
}

function get_acf( $field_name, $options = array(), $attributes = array() ) {

    if ( !function_exists( 'get_field' ) ) {
        return;
    }

    $defaultOptions = array(
        'size' => false,
        'link' => false,
        'url' => false,
        'array' => false,
        'lazy_load' => true,
        'slick' => false,
        'echo' => false,
    );

    $options = array_merge($defaultOptions, $options);

    extract($options);

    // if field_option is set
    if( is_array($field_name) ) {
        $imageArray = $field_name;
    } elseif( is_string($field_name) ) {
        $imageArray = get_field( $field_name, $field_option );
    } elseif( is_string($field_name) && $field_option == null ) {
        $imageArray = get_field( $field_name );
    } else {
        return;
    }

    $content = false;

    if($imageArray && isset($imageArray['url']) ) {
        $originalImageUrl = $imageArray['url'];
        $imageUrl = $originalImageUrl;
        $imageAlt = $imageArray['alt'];
        $imageWidth = $imageArray['width'];
        $imageHeight = $imageArray['height'];

        if($size && isset($imageArray['sizes'][$size])) {
            $imageUrl = $imageArray['sizes'][$size];
            $imageWidth = $imageArray['sizes'][$size.'-width'];
            $imageHeight = $imageArray['sizes'][$size.'-height'];
        }

        if($imageUrl) {

            $defaultAttributes = array(
                'class' => 'img-responsive',
                'width' => $imageWidth,
                'height' => $imageHeight,
                'src' => $imageUrl,
                'alt' => $imageAlt
            );
            $attributes = array_merge($defaultAttributes, $attributes);

            if($lazy_load && $slick ) {
                $attributes['data-lazy'] = $attributes['src'];
                unset($attributes['src']);
            }

            $attributesString = '';
            foreach ($attributes as $attribute => $value) {
                $attributesString .= $attribute.'="'.$value.'"';
            }

            $element = '<img '.$attributesString.' />';
            if($lazy_load && !$slick ) {
                $element = apply_filters( 'bj_lazy_load_html', $element );
            }
        }

        if($link) {
            $element = '<a href="'.$originalImageUrl.'">'.$element.'</a>';
        }

        if($url) {
            $element = $imageUrl;
        }

        if($array) {
            $element = array(
                'url' => $imageUrl,
                'width' => $imageWidth,
                'height' => $imageHeight
            );
        }

        $content = $element;
    } elseif( $imageArray ) {
        $content = $imageArray;
    }

    if( $echo ) {
        echo $content;
    } else {
        return $content;
    }
}

function get_current_domain() {

    $domain = 'http';

    if ( isset( $_SERVER['HTTPS'] ) ) {
        $domain .= 's';
    }

    $domain .= '://' . $_SERVER['HTTP_HOST'];

    return $domain;

}

function get_current_url() {

    $current_url = explode("?", $_SERVER['REQUEST_URI']);
    return get_current_domain() . $current_url[0];

}

?>