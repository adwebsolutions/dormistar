/**
 * Created by yailet on 29-May-17.
 */
(function ($) {
    jQuery(document).ready(function ($) {
        "use strict";
        var $ = jQuery;
        var $window = $(window);


        /*-----------------------------------------------------------------------------------*/
        /* Top Bar
         /*-----------------------------------------------------------------------------------*/
        if( $('body').hasClass('sticky-header') ){

            $(window).scroll(function(){

                var $window = $(this);

                if( $window.width() > 600 ){    // work only above 600px screen size
                    var $body = $('body');
                    var $top = $('.top-bar-wrapper');

                    /* get the admin bar height */
                    var adminBarHeight = 0;
                    if( $body.hasClass('admin-bar') ){
                        adminBarHeight = $('#wpadminbar').outerHeight();
                    }

                    /* header height */
                    var headerHeight = $top.outerHeight();

                    if ( $window.scrollTop() > 0 ) {
                        $top.removeClass('nav-down').addClass('nav-up');
                        $top.css('top', adminBarHeight);
                        $body.css( 'padding-top', headerHeight );
                    }else{
                        $top.removeClass('nav-up').addClass('nav-down');
                        //$top.css('top', 'auto');
                        $body.css( 'padding-top', 50);
                    }
                }

            });
        }
    });
})(jQuery);