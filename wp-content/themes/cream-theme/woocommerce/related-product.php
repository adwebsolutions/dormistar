<?php
/**
 * The template for displaying product in related products loop
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array('item');
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<div <?php post_class( $classes ); ?>>

    <article>

	    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

        <figure>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'shop_catalog' , array( 'class' => 'img-responsive' ) ); ?>
            </a>
            <?php if ( $price_html = $product->get_price_html() ) : ?>
                <figcaption><?php echo $price_html; ?></figcaption>
            <?php endif; ?>
        </figure>

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10     // Note: this hook is unregistered in this theme
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>



        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5     // Note: this hook is unregistered in this theme
			 * @hooked woocommerce_template_loop_price - 10     // Note: this hook is unregistered in this theme
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

    </article>

</div>