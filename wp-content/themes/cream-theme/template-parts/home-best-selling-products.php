<div class="home-products">

    <?php
    global $theme_options;

    if ( !empty ( $theme_options['best_selling_products_title'] ) ) {
        ?>
        <div class="container text-center">
            <div class="row">
                <h2 class="section-title fade-in-up <?php echo inspiry_animation_class(); ?>"><?php echo $theme_options['best_selling_products_title']; ?></h2>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="container fade-in-up <?php echo inspiry_animation_class(); ?>">

            <?php
            $columns = 4;
            if( !empty( $theme_options['best_selling_columns'] ) ){
                $columns = intval( $theme_options['best_selling_columns'] );
            }

            $rows = 1;
            if( !empty( $theme_options['best_selling_rows'] ) ){
                $rows = intval( $theme_options['best_selling_rows'] );
            }

            $per_page = $rows * $columns;

            // Sale Products Shortcode
            if ( is_woocommerce_activated() ){

                echo do_shortcode('[best_selling_products per_page="'.$per_page.'" columns="'.$columns.'"]');

            } else {

                ?>
                <div class="col-xs-12 text-center">
                    <p><?php _e('Best selling products section requires WooCommerce plugin', 'framework'); ?></p>
                </div>
                <?php

            }

            ?>

    </div><!-- end of container -->

</div><!-- end of home-products -->


