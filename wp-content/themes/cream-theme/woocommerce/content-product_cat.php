<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = 'item';

if( $woocommerce_loop['columns'] == 4 ){
    $classes .= ' col-md-3';
    $classes .= ' col-xs-6';
} else if( $woocommerce_loop['columns'] == 6 ){
    $classes .= ' col-md-2';
    $classes .= ' col-xs-6';
} else {
    $classes .= ' col-md-4';
    $classes .= ' col-xs-6';
}

$classes .= ' fadeInUp';
$classes .= ' '.inspiry_animation_class();
?>
<div class="<?php echo $classes; ?> product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">

    <article>

	    <?php do_action( 'woocommerce_before_subcategory', $category ); ?>

        <figure>
	        <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
                <?php
                    /**
                     * woocommerce_before_subcategory_title hook
                     *
                     * @hooked woocommerce_subcategory_thumbnail - 10
                     */
                    do_action( 'woocommerce_before_subcategory_title', $category );
                ?>
	        </a>
        </figure>

        <h4 class="title">
            <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
                <?php echo $category->name; ?>
                <?php
                /**
                 * woocommerce_after_subcategory_title hook
                 */
                do_action( 'woocommerce_after_subcategory_title', $category );
                ?>
            </a>
        </h4>

        <a class="button" href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
            <?php
            if ( $category->count > 0 ){
                echo apply_filters( 'woocommerce_subcategory_count_html', $category->count . ' ' . __('Products','woocommerce'), $category );
            }
            ?>
        </a>

	    <?php do_action( 'woocommerce_after_subcategory', $category ); ?>

    </article>

</div>