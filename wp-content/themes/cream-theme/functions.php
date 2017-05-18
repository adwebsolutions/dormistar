<?php
/**
 * The current version of the theme.
 */
define( 'INSPIRY_THEME_VERSION', '1.3.3' );

/*-----------------------------------------------------------------------------------*/
/*	Basic Theme Setup
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_theme_setup')) {
    function inspiry_theme_setup(){

        /*	Load Text Domain */
        load_theme_textdomain('framework', get_template_directory() . '/languages');

        /*	Add Automatic Feed Links Support */
        add_theme_support('automatic-feed-links');

        /* Add Post Formats Support */
        add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'video', 'audio'));

        /* Add Menu Support */
        add_theme_support('menus');
        register_nav_menus(
            array(
                'main-menu' => __('Main Menu', 'framework'),
                'footer-menu' => __('Footer Menu', 'framework')
            )
        );

        /* Add Post Thumbnails Support and Related Image Sizes */
        add_theme_support('post-thumbnails');
        add_image_size('standard-thumb', 770, 9999, false);             // For Featured Image on Post and Page
        add_image_size('full-width-thumb', 1170, 9999, false);          // For Featured Image on Full Width Page and Portfolio Item Detail Page
        add_image_size('blog-gallery-thumb', 770, 480, true);           // For Gallery Slider on Single and Blog Page
        add_image_size('portfolio-thumb', 570, 470, true);              // Portfolio Thumbnail
        add_image_size('portfolio-gallery-thumb', 1170, 700, true);     // Portfolio Slider Thumbnail for Portfolio Detail Page
        add_image_size('portfolio-thumb-home', 300, 200, true);         // Portfolio Thumbnail for Home

        /* Add woocommerce support */
        add_theme_support( 'woocommerce' );

        /* Add title tag support */
        add_theme_support( 'title-tag' );

    }
}
add_action('after_setup_theme', 'inspiry_theme_setup');


/*-----------------------------------------------------------------------------------*/
/*	TGM Plugin Activation Class and related code to get the plugins installed and activated
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory() . '/tgm/class-tgm-plugin-activation.php');
require_once(get_template_directory() . '/tgm/plugins-list.php');


/*-----------------------------------------------------------------------------------*/
/*	Include Theme Options Framework
/*-----------------------------------------------------------------------------------*/
if ( class_exists('ReduxFramework') ) {
    require_once ( get_template_directory() . '/theme-options/extension-loader/loader.php' );
    require_once( get_template_directory() . '/theme-options/theme-options-config.php' );
}


/*-----------------------------------------------------------------------------------*/
/*	Include Contact Form Handler and Theme Comment
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory() . '/include/contact_form_handler.php');
require_once(get_template_directory() . '/include/theme_comment.php');


/*-----------------------------------------------------------------------------------*/
/*	Include Meta Box
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory() . '/meta-box/config-meta-boxes.php');


/*-----------------------------------------------------------------------------------*/
/*	Include Shortcodes
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory() . '/include/shortcodes/elements.php');


/*-----------------------------------------------------------------------------------*/
/*	Include Custom Post Types
/*-----------------------------------------------------------------------------------*/
require_once( get_template_directory() . '/include/testimonial-post-type.php' );
require_once( get_template_directory() . '/include/faq-post-type.php' );
require_once( get_template_directory() . '/include/portfolio-post-type.php' );


/*-----------------------------------------------------------------------------------*/
/*	Include WooCommerce Related Theme Functions
/*-----------------------------------------------------------------------------------*/
require_once( get_template_directory() . '/include/inspiry-woocommerce-functions.php' );



/*-----------------------------------------------------------------------------------*/
//	Dynamic CSS
/*-----------------------------------------------------------------------------------*/
require_once( get_template_directory() . '/css/dynamic-css.php' );


/*-----------------------------------------------------------------------------------*/
/*	Register and load admin javascript
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_admin_js')) {
    function inspiry_admin_js($hook){
        if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
            if( isset( $_GET['post'] ) ){
                $post_id = intval($_GET['post']);
                if ("post" == get_post_type($post_id)) {
                    wp_register_script('admin-script', get_template_directory_uri() . '/js/admin.js', 'jquery');
                    wp_enqueue_script('admin-script');
                }
            }
        }
    }
}
add_action('admin_enqueue_scripts', 'inspiry_admin_js', 10, 1);


/*-----------------------------------------------------------------------------------*/
/*	Add Widget Areas
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_widgets_init')) {
    function inspiry_widgets_init(){
        // Location: Default Sidebar
        register_sidebar(array(
            'id' => 'blog',
            'name' => __('Blog Sidebar', 'framework'),
            'description' => __('This sidebar is for blog, blog posts.', 'framework'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>'
        ));

        // Location: Page Sidebar
        register_sidebar(array(
            'id' => 'page',
            'name' => __('Page Sidebar', 'framework'),
            'description' => __('This sidebar is for pages.', 'framework'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>'
        ));

        // Location: FAQs Sidebar
        register_sidebar(array(
            'id' => 'faqs',
            'name' => __('FAQs Sidebar', 'framework'),
            'description' => __('This sidebar is for FAQs page template.', 'framework'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>'
        ));

        // Location: Shop Sidebar
        register_sidebar(array(
            'id' => 'shop',
            'name' => __('Shop Sidebar', 'framework'),
            'description' => __('This sidebar is for shop page', 'framework'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>'
        ));
    }
}
add_action( 'widgets_init', 'inspiry_widgets_init' );


/*-----------------------------------------------------------------------------------*/
/*	Inspiry Theme Pagination
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_pagination')) {
    function inspiry_pagination($query){
        echo "<div class='pagination'>";
        $big = 999999999; // need an unlikely integer
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'prev_text' => __(' < ', 'framework'),
            'next_text' => __(' > ', 'framework'),
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages
        ));
        echo "</div>";
    }
}


/*-----------------------------------------------------------------------------------*/
/*	List Gallery Images
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_list_gallery_images')) {
    function inspiry_list_gallery_images($size = 'blog-gallery-thumb') {

        global $post;
        $gallery_images = rwmb_meta('inspiry_meta_gallery', 'type=plupload_image&size=' . $size, $post->ID);

        if (!empty($gallery_images)) {
            ?>
            <div class="slider-gallery-type-post">
                <ul class="slides">
                <?php
                foreach ($gallery_images as $gallery_image) {
                    $caption = (!empty($gallery_image['caption'])) ? $gallery_image['caption'] : $gallery_image['alt'];
                    echo '<li><a data-imagelightbox="gallery" href="' . $gallery_image['full_url'] . '" title="' . $caption . '" >';
                    echo '<img class="img-responsive" src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
                    echo '</a></li>';
                }
                ?>
                </ul>
            </div>
            <?php
        } else {
            inspiry_standard_thumbnail();
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/*	For portfolio item detail page
/*  Gallery Images or fallback to Video or fallback to featured image
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_portfolio_item_header')) {
    function inspiry_portfolio_item_header( $size = 'portfolio-gallery-thumb' ) {
        // check if meta box plugin is installed
        if( function_exists('rwmb_meta') ){
            global $post;
            $gallery_images = rwmb_meta('inspiry_meta_gallery', 'type=plupload_image&size=' . $size, $post->ID);

            if (!empty($gallery_images)) {
                ?>
                <div class="portfolio-item-gallery">
                    <ul class="slides">
                        <?php
                        foreach ( $gallery_images as $gallery_image ) {
                            $caption = ( !empty($gallery_image['caption']) ) ? $gallery_image['caption'] : $gallery_image['alt'];
                            echo '<li><a data-imagelightbox="gallery" href="' . $gallery_image['full_url'] . '" title="' . $caption . '" >';
                            echo '<img class="img-responsive" src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
                            echo '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <?php
            } else {
                $embed_code = get_post_meta($post->ID, 'inspiry_meta_embed_code', true); // video embed code
                if( !empty( $embed_code ) ) {
                    ?>
                    <div class="video clearfix">
                        <div class="video-wrapper clearfix">
                            <?php echo stripslashes(htmlspecialchars_decode($embed_code)); ?>
                        </div>
                    </div>
                    <?php
                } else {
                    inspiry_standard_thumbnail( 'full-width-thumb' );
                }
            }

        } else {
            inspiry_standard_thumbnail( 'full-width-thumb' );
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/*	List Gallery Images based on custom gallery meta data
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_list_custom_gallery_images')) {
    function inspiry_list_custom_gallery_images( $size = 'gallery-post-single' ) {
        ?>
        <ul class="slides">
            <?php
            global $post;
            $gallery_images = rwmb_meta('MEDICAL_META_custom_gallery', 'type=plupload_image&size=' . $size, $post->ID);
            if (!empty($gallery_images)) {
                foreach ($gallery_images as $gallery_image) {
                    $caption = (!empty($gallery_image['caption'])) ? $gallery_image['caption'] : $gallery_image['alt'];
                    echo '<li><a href="' . $gallery_image['full_url'] . '" title="' . $caption . '" >';
                    echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
                    echo '</a></li>';
                }
            } else if ( has_post_thumbnail($post->ID) ) {
                echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
                the_post_thumbnail($size);
                echo '</a></li>';
            }
            ?>
        </ul>
    <?php
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Inspiry Standard Featured Image
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_standard_thumbnail')) {
    function inspiry_standard_thumbnail($size = 'standard-thumb') {
        global $post;
        if ( has_post_thumbnail( $post->ID ) && ( is_singular('post') || is_singular('portfolio-item') ) ) {
            $image_id = get_post_thumbnail_id();
            $full_image_url = wp_get_attachment_url($image_id);
            ?>
            <figure>
                <a  data-imagelightbox="lightbox" href="<?php echo $full_image_url; ?>" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail( $size, array('class'=>"img-responsive") ); ?>
                </a>
            </figure>
            <?php
        } else if ( has_post_thumbnail($post->ID) ) {
            ?>
            <figure>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php the_post_thumbnail( $size, array('class'=>"img-responsive") ); ?>
                </a>
            </figure>
            <?php
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Get Banner Image
/*-----------------------------------------------------------------------------------*/
if (!function_exists('get_banner_image')) {
    function get_banner_image() {
        global $post;
        if( isset( $post->ID ) ){
            $banner_image_id = get_post_meta( $post->ID, 'inspiry_meta_banner_image', true );
            if ( $banner_image_id ) {
                return wp_get_attachment_url($banner_image_id);
            }
        }

        return get_default_banner();
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Get Shop Banner Image
/*-----------------------------------------------------------------------------------*/
if (!function_exists('get_shop_banner_image')) {
    function get_shop_banner_image() {
        if ( is_woocommerce_activated() ) {

            $woo_page_id = false;

            if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) {
                $woo_page_id = intval( get_option( 'woocommerce_shop_page_id' ) );
            } elseif ( is_cart() ) {
                $woo_page_id = intval( get_option( 'woocommerce_cart_page_id' ) );
            } elseif ( is_checkout() ) {
                $woo_page_id = intval( get_option( 'woocommerce_checkout_page_id' ) );
            } elseif ( is_account_page() ) {
                $woo_page_id = intval( get_option( 'woocommerce_myaccount_page_id' ) );
            }

            // get page banner
            if( $woo_page_id ){
                $banner_image_id = get_post_meta( $woo_page_id, 'inspiry_meta_banner_image', true );
                if ( $banner_image_id ) {
                    return wp_get_attachment_url( $banner_image_id );
                }
            }

        }
        return get_default_banner();
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Get Default Banner
/*-----------------------------------------------------------------------------------*/
if (!function_exists('get_default_banner')) {
    function get_default_banner()
    {
        global $theme_options;
        $banner_image_path = "";
        if (!empty($theme_options['default_page_banner'])) {
            $banner_image_path = $theme_options['default_page_banner']['url'];
        }
        return empty($banner_image_path) ? get_template_directory_uri() . '/images/banner.jpg' : $banner_image_path;
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Animation Class
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_animation_class')) {
    function inspiry_animation_class( $must_generate = false ){
        global $theme_options;
        if( $must_generate || $theme_options['animation'] ){
            return 'animated';
        }else{
            return '';
        }
    }
}
if (!function_exists('inspiry_col_animation_class')) {
    function inspiry_col_animation_class( $number_of_cols = 3, $col_index ){

        $flat_index = $col_index + 1;

        /* For 1 Column Layout */
        if( $number_of_cols == 1 ){
            return 'fade-in-up';
        }

        /* For 2 Columns Layout */
        if( $number_of_cols == 2 ){
            if( $flat_index % 2 == 0 ){
                return 'fade-in-right';
            }else{
                return 'fade-in-left';
            }
        }

        /* For 3 Columns Layout */
        if( $number_of_cols == 3 ){
            if( $flat_index % 3 == 0 ){
                return 'fade-in-right';
            }else if( $flat_index % 3 == 1 ){
                return 'fade-in-left';
            }else{
                return 'fade-in-up';
            }
        }

        /* For 4 Columns Layout */
        if( $number_of_cols == 4 ){
            if( $flat_index % 4 == 0 ){
                return 'fade-in-right';
            }else if( $flat_index % 4 == 1 ){
                return 'fade-in-left';
            }else{
                return 'fade-in-up';
            }
        }

        return 'fade-in-up';
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Load Required CSS Styles
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_load_styles')) {
    function inspiry_load_styles()
    {
        if (!is_admin()) {

            // enqueue required fonts
            $protocol = is_ssl() ? 'https' : 'http';
            wp_enqueue_style('google-open-sans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic");
            wp_enqueue_style('google-lily-script-one', "$protocol://fonts.googleapis.com/css?family=Lily+Script+One&subset=latin,latin-ext");
            wp_enqueue_style('google-Leckerli-one', "$protocol://fonts.googleapis.com/css?family=Leckerli+One");

            wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), INSPIRY_THEME_VERSION, 'all');
            wp_register_style('flexslider', get_template_directory_uri() . '/js/flexslider/flexslider.css', array(), '2.2.0', 'all');
            wp_register_style('owl-carousel', get_template_directory_uri() . '/js/carousel/owl.carousel.css', array(), '1.24', 'all');
            wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.0.3', 'all');
            wp_register_style('selectric', get_template_directory_uri() . '/css/selectric.css', array(), '1.0', 'all');
            wp_register_style('image-light-box-css', get_template_directory_uri() . '/js/image-lightbox/image-light-box.css', array(), '1.0', 'all');
            wp_register_style('meanmenu', get_template_directory_uri() . '/css/meanmenu.css', array(), '2.0.6', 'all');
            wp_register_style('responsive-tables', get_template_directory_uri() . '/css/responsive-tables.css', array(), '2.1.4', 'all');
            wp_register_style('animate', get_template_directory_uri() . '/css/animate.css', array(), '1.0', 'all');
            wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), INSPIRY_THEME_VERSION, 'all');
            wp_register_style('parent-default', get_stylesheet_uri(), array(), '1.0', 'all');
            wp_register_style('parent-custom', get_template_directory_uri() . '/css/custom.css', array(), '1.0', 'all');

            // enqueue bootstrap styles
            wp_enqueue_style('bootstrap');

            // enqueue flex slider styles
            wp_enqueue_style('flexslider');

            // enqueue owl carousel styles
            wp_enqueue_style('owl-carousel');

            // enqueue font awesome styles
            wp_enqueue_style('font-awesome');

            // enqueue select box styles
            wp_enqueue_style('selectric');

            // enqueue light box styles
            wp_enqueue_style('image-light-box-css');

            // enqueue mean menu styles
            wp_enqueue_style('meanmenu');

            // enqueue responsive tables stylesheet
            wp_enqueue_style('responsive-tables');

            // enqueue animate css
            wp_enqueue_style('animate');

            // enqueue theme's main stylesheet
            wp_enqueue_style('main');

            // default stylesheet
            wp_enqueue_style('parent-default');

            // if rtl is enabled
            if ( is_rtl() ) {
                wp_enqueue_style('rtl-main', get_template_directory_uri() . '/css/rtl-main.css', array(), '1.0', 'all');
            }

            // enqueue custom stylesheet
            wp_enqueue_style('parent-custom');

        }
    }
}
add_action('wp_enqueue_scripts', 'inspiry_load_styles');


/*-----------------------------------------------------------------------------------*/
/*	Load Required JS Scripts
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_load_scripts')) {
    function inspiry_load_scripts() {
        if (!is_admin()) {

            /* Defining scripts directory uri */
            $js_path = get_template_directory_uri() . '/js/';

            /* Registering Scripts */
            wp_register_script('modernizr', $js_path . 'modernizr.custom.js', array('jquery'), '2.6.2', false);
            wp_register_script('bootstrap', $js_path . 'bootstrap.js', array('jquery'), '3.0.3', true);
            wp_register_script('flexslider', $js_path . 'flexslider/jquery.flexslider-min.js', array('jquery'), '2.2.2', true);
            wp_register_script('image-light-box-js', $js_path . 'image-lightbox/imagelightbox.js', array('jquery'), '1.0', true);
            wp_register_script('isotope', $js_path . 'jquery.isotope.min.js', array('jquery'), '2.0', true);
            wp_register_script('owl-carousel', $js_path . 'carousel/owl.carousel.min.js', array('jquery'), '1.31', true);

            wp_register_script('appear', $js_path . 'jquery.appear.js', array('jquery'), '0.3.3', true);
            wp_register_script('hoverdir', $js_path . 'jquery.hoverdir.js', array('jquery'), '1.0', true);
            wp_register_script('validate', $js_path . 'jquery.validate.min.js', array('jquery'), '1.11.1', true);
            wp_register_script('jquery-form', $js_path . 'jquery.form.js', array('jquery'), '3.45.0', true);
            wp_register_script('selectric', $js_path . 'jquery.selectric.min.js', array('jquery'), '1.7.0', true);
            wp_register_script('transit', $js_path . 'jquery.transit.js', array('jquery'), '0.9.9', true);
            wp_register_script('meanmenu', $js_path . 'jquery.meanmenu.min.js', array('jquery'), '2.0.6', true);

            /* Custom Script */
            wp_register_script('custom-script', $js_path . 'custom.js', array('jquery'), INSPIRY_THEME_VERSION, true);

            /* Enqueue Scripts that are needed on all the pages */
            wp_enqueue_script('jquery');
            wp_enqueue_script('modernizr');
            wp_enqueue_script('bootstrap');
            wp_enqueue_script('flexslider');
            wp_enqueue_script('owl-carousel');
            wp_enqueue_script('appear');
            wp_enqueue_script('hoverdir');
            wp_enqueue_script('image-light-box-js');
            wp_enqueue_script('isotope');
            wp_enqueue_script('validate');
            wp_enqueue_script('jquery-form');
            wp_enqueue_script('selectric');
            wp_enqueue_script('transit');
            wp_enqueue_script('meanmenu');

            /* default map query arguments */
            $google_map_arguments = array ();

            // Google Map API
            if ( is_page_template('contact-template.php') ) :
                wp_enqueue_script(
                    'google-map-api',
                    esc_url_raw(
                        add_query_arg(
                            apply_filters(
                                'inspiry_google_map_arguments',
                                $google_map_arguments
                            ),
                            '//maps.google.com/maps/api/js'
                        )
                    ),
                    array(),
                    '3.21',
                    false
                );
            endif;

            /* Comments Script */
            if ( is_single() || is_page() ) {
                wp_enqueue_script('comment-reply');
            }

            /* Custom Script */
            wp_enqueue_script('custom-script');
        }
    }
}
add_action('wp_enqueue_scripts', 'inspiry_load_scripts');


/*-----------------------------------------------------------------------------------*/
/*	Custom Excerpt Method
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_excerpt')) {
    function inspiry_excerpt($len = 15, $trim = "&hellip;")
    {
        $limit = $len + 1;
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        $num_words = count($excerpt);
        if ($num_words >= $len) {
            $last_item = array_pop($excerpt);
        } else {
            $trim = "";
        }
        $excerpt = implode(" ", $excerpt) . "$trim";
        echo $excerpt;
    }
}


if (!function_exists('get_inspiry_excerpt')) {
    function get_inspiry_excerpt($len = 15, $trim = "&hellip;")
    {
        $limit = $len + 1;
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        $num_words = count($excerpt);
        if ($num_words >= $len) {
            $last_item = array_pop($excerpt);
        } else {
            $trim = "";
        }
        $excerpt = implode(" ", $excerpt) . "$trim";
        return $excerpt;
    }
}


if (!function_exists('inspiry_comment_excerpt')) {
    function inspiry_comment_excerpt($len = 15, $comment_content = "", $trim = "&hellip;")
    {
        $limit = $len + 1;
        $excerpt = explode(' ', $comment_content, $limit);
        $num_words = count($excerpt);
        if ($num_words >= $len) {
            $last_item = array_pop($excerpt);
        } else {
            $trim = "";
        }
        $excerpt = implode(" ", $excerpt) . "$trim";
        echo $excerpt;
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Generate Dynamic JavaScript
/*-----------------------------------------------------------------------------------*/
if (!function_exists('generate_dynamic_javascript')) {
    function generate_dynamic_javascript()
    {

        if (is_page_template('contact-template.php')) {
            global $theme_options;
            /* check if related theme option is enabled */
            if ($theme_options['display_google_map'] && !empty($theme_options['google_map_latitude']) && !empty($theme_options['google_map_longitude']) ) {
                /* Generate */
                ?>
                <script>
                    function initializeContactMap() {
                        var officeLocation = new google.maps.LatLng(<?php  echo $theme_options['google_map_latitude'];  ?>, <?php echo $theme_options['google_map_longitude'];  ?>);
                        var contactMapOptions = {
                            zoom:  <?php echo $theme_options['google_map_zoom'];  ?>,
                            center: officeLocation,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            scrollwheel: false
                        }
                        var contactMap = new google.maps.Map(document.getElementById('map-canvas'), contactMapOptions);

                        var contactMarker = new google.maps.Marker({
                            position: officeLocation,
                            map: contactMap
                        });

                    }
                    window.onload = initializeContactMap();
                </script>
            <?php
            }
        }
    }
}
/* Attach dynamic javascript generation function with wp_footer action hook */
add_action('wp_footer', 'generate_dynamic_javascript');



/*-----------------------------------------------------------------------------------*/
/*	HTML5 shim IE8 support of HTML5 elements
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_ie_html5_shim')) {
    function add_ie_html5_shim()
    {
        echo '<!--[if lt IE 9]>';
        echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
        echo '<script src="' . get_template_directory_uri() . '/js/respond.min.js"></script>';
        echo '<![endif]-->';
    }
}
add_action('wp_head', 'add_ie_html5_shim');


/*-----------------------------------------------------------------------------------*/
/*	Content Width
/*-----------------------------------------------------------------------------------*/
if (!isset($content_width)) $content_width = 1170;


/*-----------------------------------------------------------------------------------*/
/*	Add Class Next Post Link
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_class_next_post_link')) {
    function add_class_next_post_link($html)
    {
        $html = str_replace('<a', '<a class="next fa fa-chevron-right"', $html);
        return $html;
    }
}
add_filter('next_post_link', 'add_class_next_post_link', 10, 1);


if (!function_exists('add_class_previous_post_link')) {
    function add_class_previous_post_link($html)
    {
        $html = str_replace('<a', '<a class="prev fa fa-chevron-left"', $html);
        return $html;
    }
}
add_filter('previous_post_link', 'add_class_previous_post_link', 10, 1);


/*-----------------------------------------------------------------------------------*/
/*	Some Helper Functions
/*-----------------------------------------------------------------------------------*/
if (!function_exists('nothing_found')) {
    function nothing_found($message) {
        ?><p class="nothing-found"><?php echo $message; ?></p><?php
    }
}


/*-----------------------------------------------------------------------------------*/
//	Generate Quick CSS
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'generate_quick_css' ) ){
    function generate_quick_css(){
        global $theme_options;

        if( isset($theme_options['quick_css']) ){
            // Quick CSS from Theme Options
            $quick_css = stripslashes( $theme_options['quick_css'] );

            if( !empty($quick_css) ){
                echo "\n<style type='text/css' id='quick-css'>\n";
                echo $quick_css . "\n";
                echo "</style>". "\n\n";
            }
        }
    }
}
add_action('wp_head', 'generate_quick_css');


/*-----------------------------------------------------------------------------------*/
//	Generate Quick JavaScript
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'generate_quick_js' ) ){
    function generate_quick_js(){
        global $theme_options;
        if ( isset( $theme_options[ 'quick_js' ] ) ) {
            // Quick JS from Theme Options
            $quick_js = stripslashes($theme_options['quick_js']);
            if(!empty($quick_js)){
                echo "\n<script type='text/javascript' id='quick-js'>\n";
                echo $quick_js . "\n";
                echo "</script>". "\n\n";
            }
        }
    }
    add_action('wp_footer', 'generate_quick_js');
}


/*-----------------------------------------------------------------------------------*/
//	Check if woocommerce is activated
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'WooCommerce' ) ) {
            return true;
        } else {
            return false;
        }
    }
}


/*-----------------------------------------------------------------------------------*/
//	Author social links
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'add_social_links_to_profile' ) ) {
    function add_social_links_to_profile( $contact_methods ) {

        $contact_methods['facebook_profile'] = __('Facebook Profile URL', 'framework');
        $contact_methods['google_profile'] = __('Google Profile URL', 'framework');
        $contact_methods['twitter_profile'] = __('Twitter Profile URL', 'framework');
        $contact_methods['linkedin_profile'] = __('Linkedin Profile URL', 'framework');
        $contact_methods['rss_url'] = __('RSS URL','framework');

        return $contact_methods;
    }
}
add_filter( 'user_contactmethods', 'add_social_links_to_profile', 10, 1);


/*-----------------------------------------------------------------------------------*/
//	Column Count
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('inspiry_col_count') ) {
    function inspiry_col_count( $items_count ){
        if ( $items_count % 4 == 0 ) {
            return 4;
        } else if ( $items_count % 3 == 0 ) {
            return 3;
        } else if ( $items_count % 2 == 0 ) {
            return 2;
        } else if ( $items_count == 1 ){
            return 1;
        } else {
            if( ( $items_count % 4 ) < ( $items_count % 3 ) ){
                return 3;
            }else{
                return 4;
            }
        }
    }
}


/*-----------------------------------------------------------------------------------*/
//	Classes Based on Columns
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_col_classes' ) ) {
    function inspiry_col_classes( $columns_count ){
        if ( $columns_count == 4 ) {
            return "col-md-3 col-sm-6 col-xs-12";
        } else if ( $columns_count == 3 ) {
            return "col-md-4 col-sm-6 col-xs-12";
        } else if ( $columns_count == 2 ) {
            return "col-sm-6 col-xs-12";
        } else if ( $columns_count == 1 ){
            return "col-xs-12";
        } else {
            return "col-md-4 col-sm-6 col-xs-12";
        }
    }
}


/*-----------------------------------------------------------------------------------*/
//	Clearfix Class Based on Columns and Column Index
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_col_clearfix' ) ) {
    function inspiry_col_clearfix( $col_count, $loop_counter )
    {
        if ($col_count == 2) {
            if ($loop_counter % 2 == 0) {
                ?>
                <div class="clearfix visible-lg"></div>
                <div class="clearfix visible-md"></div>
                <div class="clearfix visible-sm"></div>
                <?php
            }
        } else if (($col_count) == 3 || ($col_count == 4)) {
            if ($loop_counter % $col_count == 0) {
                ?>
                <div class="clearfix visible-lg"></div>
                <div class="clearfix visible-md"></div>
                <?php
            }
            if ($loop_counter % 2 == 0) {
                ?>
                <div class="clearfix visible-sm"></div>
                <?php
            }
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/*	Sticky Header Class
/*-----------------------------------------------------------------------------------*/
if ( !function_exists('inspiry_sticky_header') ) {
    function inspiry_sticky_header($classes){
        global $theme_options;
        if( $theme_options['sticky_header'] ){
            $classes[] = 'sticky-header';
        }
        return $classes;
    }
	add_filter('body_class', 'inspiry_sticky_header');
}


/*-----------------------------------------------------------------------------------*/
/*	Google Maps API Key
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_google_maps_api_key' ) ) :
	/**
	 * This function adds API key ( if provided in settings ) to google maps arguments
	 */
	function inspiry_google_maps_api_key( $google_map_arguments ) {
		/* Get Google Maps API Key if available */
		global $theme_options;
		if ( isset( $theme_options[ 'google_maps_api_key' ] ) && ! empty( $theme_options[ 'google_maps_api_key' ] ) ) {
			$google_map_arguments[ 'key' ] = urlencode( $theme_options[ 'google_maps_api_key' ] );
		}

		return $google_map_arguments;
	}

	add_filter( 'inspiry_google_map_arguments', 'inspiry_google_maps_api_key' );
endif;