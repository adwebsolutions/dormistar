<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- META TAGS -->
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Define a viewport to mobile devices to use - telling the browser to assume that the page is as wide as the device (width=device-width) and setting the initial page zoom level to be 1 (initial-scale=1.0) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no" />

    <?php
    global $theme_options;
    if (!empty($theme_options['theme_favicon']) && !empty($theme_options['theme_favicon']['url'])) {
        ?>
        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo $theme_options['theme_favicon']['url']; ?>"/>
        <?php
    }
    ?>

    <!-- Pingback URL -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="<?php echo 'http://browsehappy.com/'; ?>">upgrade your browser</a> or <a href="<php echo 'http://www.google.com/chromeframe/?redirect=true'; ?>">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<!-- Start of Header Wrapper -->
<div class="header-wrapper">

    <header class="header container fadeInDown <?php echo inspiry_animation_class(); ?>">

        <div class="logo-wrapper">
            <div class="logo">
                <?php
                if (!empty($theme_options['website_logo']['url'])) {
                    ?>
                    <a href="<?php echo esc_url( home_url('/') ); ?>">
                        <img src="<?php echo $theme_options['website_logo']['url']; ?>" alt="<?php bloginfo('name'); ?>"/>
                    </a>
                <?php
                } else {
                    ?>
                    <h1 class="text-logo">
                        <a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php $site_title = get_bloginfo('name'); echo strip_tags( html_entity_decode( $site_title ) ); ?>">
                            <?php echo html_entity_decode($site_title); ?>
                        </a>
                    </h1>
                <?php
                }

                $description = get_bloginfo ( 'description' );
                if( !empty( $description ) ){
                    echo '<small class="tag-line">';
                    echo $description;
                    echo '</small>';
                }
                ?>
            </div>
        </div>

        <?php
        /* WPML Language Switcher */
        if( $theme_options['display_wpml_flags'] ){
            if( function_exists('icl_get_languages') ){
                $languages = icl_get_languages('skip_missing=0&orderby=code');
                if(!empty($languages)){
                    echo '<div id="inspiry_language_list"><ul class="clearfix">';
                    foreach($languages as $l){
                        echo '<li>';
                        if($l['country_flag_url']){
                            if(!$l['active']) echo '<a href="'.$l['url'].'" title="'.$l['translated_name'].'">';
                            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['translated_name'].'" width="18" />';
                            if(!$l['active']) echo '</a>';
                        }
                        if(!$l['active']) echo '<a href="'.$l['url'].'">';
                        echo icl_disp_language($l['native_name'], $l['translated_name']);
                        if(!$l['active']) echo '</a>';
                        echo '</li>';
                    }
                    echo '</ul></div>';
                }
            }
        }
        ?>

        <!-- Show quick view cart if WooCommerce is activated and enabled from theme options -->
        <?php
        if( is_woocommerce_activated() && $theme_options['display_cart_in_header'] ) {
            global $woocommerce;
            ?>
            <div class="mini-cart">
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
                            if ( $woocommerce->cart->cart_contents_count == 0 ) {
                                echo '<p>'.__( 'No products in the cart.', 'framework').'</p>';
                            } else {
                                ?>
                                <div class="loading">
                                    <img src="<?php echo get_template_directory_uri().'/images/ajax-loader.gif' ?>" alt="Loading..."/>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <?php  if( $theme_options['inspiry_header_search'] == 1 ) { ?>
        <!-- product search form -->
        <div class="inspiry-search-wrapper">
            <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                <input type="search" class="search-field" placeholder="<?php _e( 'Search Products...', 'framework' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php _e( 'Search For:', 'framework' ); ?>" />
                <input type="hidden" name="post_type" value="product" />
            </form>
            <a class="search-button" href=""><i class="fa fa-search"></i></a>
        </div>
        <?php } ?>

        <!-- Main Menu -->
        <div class="main-menu-wrapper">
            <nav id="nav" class="main-menu nav-collapse clearfix">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'container' => false,
                    'menu_class' => 'clearfix'
                ));
                ?>
            </nav>
        </div>


        <div class="clearfix"></div>

        <?php  if( $theme_options['inspiry_header_search'] == 1 ) { ?>
        <!-- product search form for mobile screens -->
        <div class="row mobile-search-wrapper">
            <div class="col-xs-12">
                <form method="get" class="mobile-search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-8 field-wrapper">
                            <input type="search" class="mobile-search-field" placeholder="<?php _e( 'Search Products...', 'framework' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php _e( 'Search For:', 'framework' ); ?>" />
                        </div>
                        <div class="col-sm-2 button-wrapper">
                            <input type="submit" class="mobile-search-button" value="<?php _e( 'Search', 'framework' ); ?>" />
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <input type="hidden" name="post_type" value="product" />
                </form>
            </div>
        </div>
        <?php } ?>

    </header>

    <div class="header-border-bottom"></div>

</div>
<!-- End of Header Wrapper -->