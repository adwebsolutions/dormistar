<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' );

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content container">

    <div class="row">

        <div class="main col-xs-12" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php wc_get_template_part( 'content', 'single-product' ); ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- end of main -->

    </div><!-- end of .row -->

</div><!-- end of page content -->

<?php get_footer( 'shop' ); ?>