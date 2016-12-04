var geocoder;
var mapElement;
var map;
var mapCenter;
var toolTips = [];
var markersArray = [];

function initialize() {
    mapElement = jQuery('.map');
    geocoder = new google.maps.Geocoder();

    var map_default_options = {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        panControl: false,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false
    };

    jQuery.extend(map_options, map_default_options);

    if( Object.prototype.toString.call( map_options.map_size ) === '[object Array]' ) {
        map_options.map_size = new google.maps.Size( map_options.map_size[0], map_options.map_size[1] );
    } else {
        map_options.map_size = new google.maps.Size( map_options.map_size );
    }

    // Create a new Google Map
    mapElement.each(function() {
        var _this = this;

        create_map(_this);

        set_center(map_center);

        // Add markers
        jQuery.each(map_markers, function(index, marker) {
            (function (index) {

                geocodeAddress({ 'address': marker.address }, function(location) {
                    marker.google_maps_marker = add_marker(marker, location);

                    // add_marker_listener(marker);
                });

            })(index);
        });

    });
}

function create_map(_this) {
    map = new google.maps.Map(_this, map_options);
}

function set_center(address) {
    geocodeAddress({ 'address': map_center }, function(location) {
        mapCenter = location;
        map.setCenter(location);
    });
}

function add_marker(marker, location) {

    if(marker.icon) {
        marker.icon.size = marker.icon.size ? new google.maps.Size(marker.icon.size[0], marker.icon.size[1]) : marker.icon.size ;
        marker.icon.origin = marker.icon.origin ? new google.maps.Point(marker.icon.origin[0], marker.icon.origin[1]) : marker.icon.origin ;
        marker.icon.anchor = marker.icon.anchor ? new google.maps.Point(marker.icon.anchor[0], marker.icon.anchor[1]) : marker.icon.anchor ;
    }
    
    return new google.maps.Marker({
        map : map,
        position : location,
        icon: marker.icon
    });
}

function add_marker_listener(marker) {

    google.maps.event.addListener(marker.google_maps_marker, 'click', function(event) {

        if(marker.click_event == 'link-marker' && marker.link) {
            window.open(marker.link, marker.link_target);
        }

    });
}

function geocodeAddress(address, callback) {
    geocoder.geocode(address, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            callback(results[0].geometry.location);
        } else {
            return false;
        }
    });
}

function offsetMap(_this, x, y) {
    var map_width = jQuery(_this).width();
    var map_height = jQuery(_this).height();

    if(map_width > 0 && map_height > 0) {

        // wait for google maps to load
        map_width = (map_width / 2); // divided by 2 since the marker is in the middle
        map_height = (map_height / 2); // divided by 2 since the marker is in the middle
        var offsetX = (map_width * x) - map_width; // Calculate the offset from the middle
        var offsetY = (map_height * y) - map_height; // Calculate the offset from the middle

        // Center map
        map.setCenter(mapCenter);

        map.panBy(offsetX, offsetY);
    }
}

function load_google_maps() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&callback=initialize';
    document.body.appendChild(script);
}