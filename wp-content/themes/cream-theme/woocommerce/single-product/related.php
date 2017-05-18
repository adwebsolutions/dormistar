<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$posts_per_page = 8;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

    <section class="related-products">

		<h3 class="section-title"><?php _e( 'Related Products', 'woocommerce' ); ?></h3>

        <div class="related-products-wrapper">

            <div class="related-products-carousel">

                <div class="product-control-nav">
                    <a class="prev"><i class="fa fa-angle-left"></i></a>
                    <a class="next"><i class="fa fa-angle-right"></i></a>
                </div>

                <?php woocommerce_product_loop_start(); ?>
                <div id="product-carousel" class="product-listing">
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                        <?php wc_get_template_part( 'related', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>
                </div>

                <?php woocommerce_product_loop_end(); ?>

            </div>

        </div>

    </section>

<?php endif;

wp_reset_postdata();
