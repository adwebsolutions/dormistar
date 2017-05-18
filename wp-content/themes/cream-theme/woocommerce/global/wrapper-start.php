<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $theme_options;

if( $theme_options['shop_layout'] == 'full-width' ) {
    ?><div class="main col-md-12" role="main"><?php
} else {
    ?><div class="main col-lg-9 col-md-8" role="main"><?php
}

?>