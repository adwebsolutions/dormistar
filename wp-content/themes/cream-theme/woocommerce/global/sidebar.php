<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<!-- start of sidebar -->
<aside class="sidebar product-sidebar col-lg-3 col-md-4" role="complementary">
    <?php dynamic_sidebar('shop'); ?>
</aside>
<!-- end of sidebar -->