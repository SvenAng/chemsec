jQuery.extend( jQuery.easing, {
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
        return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
    }
});

(function($) {
    var realWindowWidth = 0;

    initMenu();
    setRealWindowWidth();
    searchForm();
    initSlick();
    initFeatherlight();
    initCounters();
    checkEmptyTextarea();
    sidebarTags();
    initGoogleMaps();
    ieFix();


    $(window).on('resize', function() {
        setRealWindowWidth();
    });

    $(window).scroll(function() {
        initCounters();
    });

    function initFeatherlight() {
        $('.donate-button').on('click', function() {
            var donate_buttons = $(this).parent('.widget_bllt_donate').find('.donate-buttons');

            $.featherlight( donate_buttons );

            return false;
        });


        $('.newsletter').on('click', function() {

            get_newsletter_form();

            return false;
        });

        function get_newsletter_form() {
            $.ajax({
                url: wp.ajaxurl,
                dataType: 'HTML',
                data: { action: 'get_newsletter_form' },
                success: function( data ) {

                    data = $(data);

                    bind_form_submit(data);

                    $.featherlight( data );
                }
            });
        }

        function bind_form_submit( data ) {

            data.find('form').on('submit', function() {
                $.ajax({
                    dataType: 'HTML',
                    data: data.find('form').serialize(),
                    success: function() {
                        $('#mc4wp_widget-99 form').append('<div class="mc4wp-alert mc4wp-success">Thank you, your sign-up request was successful! <br/>Please check your e-mail inbox.</div>  ');
                    }
                });
                return false;
            });
        }
    }

    function initGoogleMaps() {
        if(typeof google == 'undefined') {
            if($('.map').length > 0) {

                var form_height = $('#wpcf7-f157-p137-o1').height();
                $('.map').height(form_height);

                load_google_maps();

                $('.map-container .map-overlay').on('click touchstart', function(event) {
                    event.stopPropagation();

                    if(event.handled !== true) { // check if event has been handled
                        if(event.type === 'click') { // Call the callback if the event was a click
                            // click
                        } else {
                            $(this).on('touchend', function() { // Touch click event
                                // touch click
                                // disable overlay
                                $('.map-container .map-overlay').css('pointer-events', 'none');
                                $(this).off('touchend');
                                return false;
                            });

                            $(this).on('touchmove', function() { // Touch move/scroll event
                                // touch drag
                                // enable overlay
                                $('.map-container .map-overlay').css('pointer-events', 'auto');
                                $(this).off('touchend');
                            });
                        }
                        event.handled = true;
                    } else {
                        return false;
                    }
                });
            }
        }
    }
    
    function setRealWindowWidth() {
        realWindowWidth = $('body').css('overflow', 'hidden').width(); $('body').css('overflow', 'auto');
    }

    function sidebarTags() {
        var tags = $('#sidebar .archive .tags');
        var siteurl = tags.data('url');
        var query_vars;
        var timeoutid;

        tags.on('click', '.tag', function() {
            var tag = $(this);
            
            // 
            if(tag.hasClass('selected')) {
                tag.removeClass('selected').blur();
            } else {
                tag.addClass('selected').blur();
            }

            clearTimeout(timeoutid);
            timeoutid = setTimeout(function() {

                query_vars = $('.tag.selected', tags).map(function() {
                    return {
                        taxonomy: $(this).data('taxonomy'), 
                        slug: $(this).data('slug')
                    };
                })
                .get();

                update_url();

                get_posts();

            }, 400);

            return false;
        });

        $('#content').on('click', '#ajax-load-more', function() {
            var paged = (wp.paged + 1);
            get_posts( paged, true );
            return false;
        });

        function update_url() {
            var url = window.location.href;
            var tags = [];
            query_vars.map(function(tag) {
                tags.push(tag.slug);
            });
            var query_vars_string = tags.join('+');
            url = url.replace(/(.+keyword\/)([^\/]+)(.*)/, '$1'+query_vars_string+'$3');

            window.history.pushState( { html:'', pageTitle:'dasdas' }, '', url );
        }

        function get_posts( paged, loadmore ) {
            var post_type = wp.post_type;

            $.ajax({
                url: wp.ajaxurl,
                dataType: 'JSON',
                type: 'post',
                data: { action: 'get_posts', tags: query_vars, post_type: post_type, paged: paged },
                success: function( data ) {

                    console.log(data);

                    if(data) {
                        wp.paged = data.paged;
                        wp.numpages = data.numpages;

                        var pagination = paging_navigation_ajax( wp.paged, wp.numpages );

                        if(loadmore) {
                            $('#content .content-footer').fadeOut(function() {
                                $('#content .content-footer').remove();
                                $('#content').append(data.html).append(pagination).fadeIn();
                            });
                        } else {
                            $('#content').fadeOut(200, function() {
                                $('#content').html(data.html).append(pagination).fadeIn();
                                // Resetbutton
                                $('#site-main .site-sidebar .back-link.reset-link').css('display', 'inline-block');
                            });
                        }
                    }

                }
            });
        }

        function paging_navigation_ajax(paged, numpages) {

            // Don't print empty markup if there's only one page.
            if ( numpages < 2 ) {
                return;
            }

            // Don't show on last page
            var html = '';

            if( paged != numpages ) {
                html =  '<div class="content-footer"><nav class="navigation paging-navigation pagination loop-pagination" role="navigation">' +
                            '<a id="ajax-load-more" class="page-numbers" href="#load-more">Load more</a>' +
                        '</nav></div>';
            }

            return html;
        }
    }

    function checkEmptyTextarea() {
        $('textarea').on('keyup blur', function() {
            var textarea = $(this);
            var a = textarea.val().length > 0 ? textarea.addClass('not-empty') : textarea.removeClass('not-empty');
        });
    }

    function initCounters() {
        $('.counter-value').each(function () {
            var scrollBottom = $(window).scrollTop() + $(window).height();
            var offset = 100;

            if(scrollBottom > $(this).offset().top + offset && !$(this).hasClass('done')) {
                var from = $(this).data('from');
                var to = $(this).data('to');
                $(this).addClass('done');

                $(this).prop('Counter', from).animate({
                    Counter: to
                }, {
                    duration: 4000,
                    easing: 'easeInOutCirc',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            }

        });
    }

    function initSlick( width ) {
        var last_width = 0;
        $('.slider').each(function() {
            var options = {};
            var id = $(this).data('slider-id');

            switch(id) {
                case 'business-tools': options = {
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    responsive: [
                        {
                            breakpoint: 930,
                            settings: {
                                arrows: false,
                            }
                        }, {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        }, {
                            breakpoint: 575,
                            settings: {
                                arrows: false,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                }; break;

                case 'business-groups': options = {
                    infinite: true,
                    slidesToShow: 7,
                    slidesToScroll: 3,
                    swipeToSlide: true,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    responsive: [
                        {
                            breakpoint: 1130,
                            settings: {
                                slidesToShow: 6,
                                slidesToScroll: 3
                            }
                        }, {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 5,
                                slidesToScroll: 2
                            }
                        }, {
                            breakpoint: 930,
                            settings: {
                                arrows: false,
                                slidesToShow: 5,
                                slidesToScroll: 2
                            }
                        }, {
                            breakpoint: 675,
                            settings: {
                                arrows: false,
                                slidesToShow: 4,
                                slidesToScroll: 1
                            }
                        }, {
                            breakpoint: 550,
                            settings: {
                                arrows: false,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        }, {
                            breakpoint: 410,
                            settings: {
                                arrows: false,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        }, {
                            breakpoint: 275,
                            settings: {
                                arrows: false,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                }; break;
            }

            $(this).slick(options).show();
        });
    }

    function initMenu() {
        var menu_trigger = $('#mobile-nav-trigger');
        var main_navigation = $('#main-navigation');
        var site_main = $('#site-main').add('#menu-close').add('#main-navigation');

        menu_trigger.on('click touchstart', function(e) {
            e.stopPropagation();

            if(e.handled !== true) {
                main_navigation.toggleClass('open');
                $('html').toggleClass('main-nav-open');

                e.handled = true;
            }

            return false;
        });

        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                close_menu();
            }
        });

        site_main.on( "click touchstart", function(event){

            if(event.target != this) return;

            close_menu();
        });

        function close_menu() {

            if(main_navigation.hasClass('open')) {
                main_navigation.removeClass('open');
                $('html').removeClass('main-nav-open');
                return false;
            }
        }
    }

    function searchForm() {
        var searchFormElement = $('#main-navigation-content .search-form');

        if(window.location.href.indexOf("s=") > -1) {
            searchFormElement.addClass('open');
        }

        searchFormElement.on('click touchstart', '.search-submit', function() {
            searchFormElement = $(this).parents('.search-form');

            if(!searchFormElement.hasClass('open')) {

                searchFormElement.addClass('open');
                return false;

            } else if( searchFormElement.hasClass('open') && !$('.search-field', searchFormElement).val() ) {

                searchFormElement.removeClass('open');
                return false;

            }
        });
    }
	function ieFix() {
	        if(isIE()) {
	            // add src to srcset img
	            $('img[srcset]').each(function() {
	                var image = $(this).attr('srcset').match(/(.+),/)[1];
	                $(this).attr('src', image);
	            });
	
	            $('#header-banner-content-wrapper > #header-banner-content').css({
	                'marginLeft': 0,
	                'marginRight': 0
	            });
	
	            $('#page').css('display', 'block');
	        }
	    }
	
	    function isIE() {
	        var ua = navigator.userAgent;
	        return ua.match(/(MSIE|Trident)/);
	    }
    

})( jQuery );