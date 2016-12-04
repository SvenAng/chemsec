<?php

$maps = get_field('bllt-map', get_the_ID());

if($maps):

    foreach ($maps as $map) {

        // Get values
        $map_center  = $map['map-center']['lat'] . ', ' . $map['map-center']['lng'];
        $map_zoom    = $map['map-zoom'];
        $map_size    = false;
        $map_style   = $map['map-style'];
        $map_markers = $map['map-markers'];

        // Set default
        $map_center = $map_center   ? $map_center                               : 'Göteborg, Sweden';
        $map_zoom   = $map_zoom     ? $map_zoom                                 : '8';
        $map_size   = $map_size     ? '['.$map_size.']'                         : '{}';
        $map_style  = $map_style    ? $map_style                                : '""';

        // Make style safe to use
        $map_style = html_entity_decode($map_style, ENT_COMPAT, 'UTF-8');
        $map_style = str_replace('&#039;', "'", $map_style);

        // Loop markers
        $map_markers_array = array();
        if($map_markers) {
            foreach ($map_markers as $map_marker_index => $map_marker) {
                $map_marker_address     = $map_marker['map-marker-address']['lat'] . ', ' . $map_marker['map-marker-address']['lng'];
                $map_marker_icon        = $map_marker['map-marker-icon'];
                $map_marker_origin      = false;
                $map_marker_anchor      = $map_marker['map-marker-icon-anchor'];
                $map_marker_click_event = false;
                $map_marker_link        = false;
                $map_marker_link_target = false;

                $map_marker_origin = $map_marker_origin ? $map_marker_origin : '0,0';
                $map_marker_anchor = $map_marker_anchor ? $map_marker_anchor : '0,0';

                if($map_marker_icon) {

                    $width = $map_marker_icon['sizes']['thumbnail-width'];
                    $height = $map_marker_icon['sizes']['thumbnail-height'];

                    $image = array(
                        'url' => $map_marker_icon['sizes']['thumbnail'],
                        'size' => array($width, $height),
                        'origin' => explode(',', $map_marker_origin),
                        'anchor' => explode(',', $map_marker_anchor)
                    );
                }

                // save all in a js object
                $map_markers_array[] = array(
                    'index'          => $map_marker_index,
                    'address'        => $map_marker_address,
                    'icon'           => $image,
                    'click_event'    => $map_marker_click_event,
                    'link'           => $map_marker_link,
                    'link_target'    => $map_marker_link_target
                );
            }
        }

        $map_markers = json_encode($map_markers_array);
    }
    ?>
    <script type="text/javascript">
        var map_markers = <?php echo $map_markers; ?>;
        var map_style = <?php echo $map_style; ?>;
        var map_center = "<?php echo $map_center; ?>";
        var map_options = {
            zoom: <?php echo $map_zoom; ?>,
            size: <?php echo $map_size; ?>,
            styles: map_style
        };
    </script>
    <div class="map-container">
        <div class="map"></div>
        <div class="map-overlay"></div>
    </div>
    <?php
endif;