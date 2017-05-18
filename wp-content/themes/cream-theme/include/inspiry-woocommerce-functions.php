<?php
if ( class_exists( 'woocommerce' ) ) {

/*-----------------------------------------------------------------------------------*/
//	Un-Register default woocommerce hooks
/*-----------------------------------------------------------------------------------*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


/*-----------------------------------------------------------------------------------*/
//	Remove WooCommerce styles and scripts.
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'woo_remove_styles_scripts' ) ){
    function woo_remove_styles_scripts() {

        // Styles
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

        // Scripts
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
        wp_dequeue_script( 'fancybox' );
        wp_dequeue_script( 'enable-lightbox' );
    }
}
add_action( 'wp_enqueue_scripts', 'woo_remove_styles_scripts', 99 );


/*-----------------------------------------------------------------------------------*/
//	Change prettyPhoto to lightbox in image html
/*-----------------------------------------------------------------------------------*/
function woo_replace_lightbox_rel($html) {
    $html = str_replace('data-rel="prettyPhoto', 'data-imagelightbox="lightbox"', $html);
    return $html;
}
add_filter('woocommerce_single_product_image_html', 'woo_replace_lightbox_rel', 99, 1); // single image
add_filter('woocommerce_single_product_image_thumbnail_html', 'woo_replace_lightbox_rel', 99, 1); // thumbnails


/*-----------------------------------------------------------------------------------*/
//	Change woocommerce image dimensions on theme activation.
/*-----------------------------------------------------------------------------------*/
/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
    add_action( 'init', 'inspiry_woocommerce_image_dimensions', 1 );
}

/**
 * Define image sizes for woocommerce
 */
function inspiry_woocommerce_image_dimensions() {

    $catalog = array(
        'width' 	=> '300',	// px
        'height'	=> '300',	// px
        'crop'		=> 1 		// true
    );

    $single = array(
        'width' 	=> '470',	// px
        'height'	=> '470',	// px
        'crop'		=> 1 		// true
    );

    $thumbnail = array(
        'width' 	=> '140',	// px
        'height'	=> '140',	// px
        'crop'		=> 1 		// true
    );

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}


/*-----------------------------------------------------------------------------------*/
//	Change number or products per row to 3
/*-----------------------------------------------------------------------------------*/
if (!function_exists('loop_columns')) {
    function loop_columns() {
        global $theme_options;
        // For Demo Variations
        if( isset( $_GET['shop_layout'] ) ){
            $theme_options['shop_layout'] = $_GET['shop_layout'];
        }
        if( $theme_options['shop_layout'] == 'full-width' ) {
            return 4; // 4 products per row
        } else {
            return 3; // 3 products per row
        }
    }
}
add_filter('loop_shop_columns', 'loop_columns');


/*-----------------------------------------------------------------------------------*/
//	WooCommerce number or products per row to 3
/*-----------------------------------------------------------------------------------*/
if (!function_exists('products_per_page')) {
    function products_per_page() {
        global $theme_options;
        if( isset( $theme_options['products_per_page'] ) ) {
            return intval( $theme_options['products_per_page'] );
        } else {
            return 12; // 12 products per page
        }
    }
}
add_filter('loop_shop_per_page', 'products_per_page');





/*-----------------------------------------------------------------------------------*/
//	social share icons for woocommerce product
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_share_social_icons' ) ) {
    function inspiry_share_social_icons() {

        global $post, $theme_options;
        $permalink = get_permalink( $post->ID );
        $post_title = rawurlencode( get_the_title( $post->ID ) );

        ?>
        <div class="share-social-icons">

            <?php
            if( $theme_options['product_share_icons']['facebook'] ) {
                ?>
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" target="_blank" title="<?php _e('Share on Facebook','framework'); ?>">
                    <i class="fa fa-facebook"></i>
                </a>
            <?php
            }

            if( $theme_options['product_share_icons']['twitter'] ) {
                ?>
                <a href="https://twitter.com/share?url=<?php echo $permalink; ?>" target="_blank" title="<?php _e('Share on Twitter','framework'); ?>">
                    <i class="fa fa-twitter"></i>
                </a>
            <?php
            }

            if($theme_options['product_share_icons']['pinterest']) {
                $featured_image_src =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
                $featured_image = $featured_image_src['0'];
                ?>
                <a href="//pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&amp;media=<?php echo $featured_image; ?>&amp;description=<?php echo $post_title; ?>" target="_blank" title="<?php _e('Pin on Pinterest','framework'); ?>">
                    <i class="fa fa-pinterest"></i>
                </a>
            <?php
            }

            if($theme_options['product_share_icons']['googleplus']) {
                ?>
                <a href="//plus.google.com/share?url=<?php echo $permalink; ?>" target="_blank" title="<?php _e('Share on Google+','framework'); ?>">
                    <i class="fa fa-google-plus"></i>
                </a>
            <?php
            }
            ?>
        </div>
    <?php
    }
}
add_action( 'woocommerce_share', 'inspiry_share_social_icons' );


/*-----------------------------------------------------------------------------------*/
//	Add to cart dropdown for Quick View Cart in Header
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_add_to_cart_dropdown' ) ) {
    function inspiry_add_to_cart_dropdown( $fragments ) {
        global $woocommerce;
        ob_start();
        ?>
        <div class="cart-inner">
            <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="cart-link">
                <div class="cart-icon">
                    <i class="fa fa-shopping-cart"></i>
                    <strong><?php echo $woocommerce->cart->cart_contents_count; ?></strong>
                </div>
            </a>
            <div class="nav-dropdown">
                <div class="nav-dropdown-inner">
                    <?php
                    if ( sizeof( $woocommerce->cart->cart_contents ) > 0 ) :
                        ?>
                        <div class="cart_list">
                            <?php
                            foreach ( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) :
                                $_product = $cart_item['data'];
                                if ( $_product->exists() && $cart_item['quantity']>0 ) :
                                    ?>
                                    <div class="row mini-cart-item">
                                        <div class="col-sm-2">
                                            <?php echo apply_filters(   'woocommerce_cart_item_remove_link',
                                                sprintf('<a href="%s" class="remove" title="%s"><i class="fa fa-close"></i></a>',
                                                    esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ),
                                                    __('Remove this item', 'framework') ), $cart_item_key );
                                            ?>
                                        </div>
                                        <div class="col-sm-7">
                                            <?php
                                            $product_title = $_product->get_title();
                                            echo '<a class="cart_list_product_title" href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $product_title, $_product) . '</a>';
                                            echo '<div class="cart_list_product_price">'. wc_price( $_product->get_price() ).' /</div>';
                                            echo '<div class="cart_list_product_quantity">'.__('Quantity', 'framework').': '.$cart_item['quantity'].'</div>';
                                            ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php   echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';                                                    ?>
                                        </div>
                                    </div><!-- end row -->
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                        <div class="minicart_total_checkout">
                            <?php _e('Cart Subtotal', 'framework'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>
                        </div>
                        <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button expanded text-uppercase"><?php _e('View Cart', 'framework'); ?></a>
                        <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button secondary expanded text-uppercase"><?php _e( 'Proceed to Checkout', 'framework' ); ?></a>
                    <?php
                    else:
                        echo '<p>'.__('No products in the cart.','framework').'</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        $fragments['.cart-inner'] = ob_get_clean();
        return $fragments;
    }
}
add_filter('add_to_cart_fragments', 'inspiry_add_to_cart_dropdown');


}
?>