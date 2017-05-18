<div class="home-products">

    <?php
    global $theme_options;

    if ( !empty ( $theme_options['product_categories_title'] ) ) {
        ?>
        <div class="container text-center">
            <div class="row">
                <h2 class="section-title fade-in-up <?php echo inspiry_animation_class(); ?>"><?php echo $theme_options['product_categories_title']; ?></h2>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="container fade-in-up <?php echo inspiry_animation_class(); ?>">

            <?php
            $number = 4;
            if( ! empty( $theme_options['number_of_categories'] ) ){
                $number = intval( $theme_options['number_of_categories'] );
            }

            $ids_attr = '';
            if( ! empty( $theme_options['product_category_ids'] ) ){

                $product_cat_ids = '';
                foreach( $theme_options['product_category_ids'] as $cat_id ){
                    $product_cat_ids .= $cat_id . ',';
                }

                $ids_attr = 'ids="'. $product_cat_ids .'"';
            }

            // Sale Products Shortcode
            if ( is_woocommerce_activated() ){

                echo do_shortcode('[product_categories '. $ids_attr .' number="'.$number.'"]');

            } else {

                ?>
                <div class="col-xs-12 text-center">
                    <p><?php _e('Product categories section requires WooCommerce plugin', 'framework'); ?></p>
                </div>
                <?php

            }

            ?>

    </div><!-- end of container -->

</div><!-- end of home-products -->


