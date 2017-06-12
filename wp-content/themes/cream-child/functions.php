<?php
/**
 * Load translation files from child theme
 *
 * Note: This function supposed to be in inspiry_theme_setup,
 * But I called it before including redux framework to support theme options translations
 */
load_child_theme_textdomain ( 'framework', get_stylesheet_directory () . '/languages' );


/*-----------------------------------------------------------------------------------*/
/*	Enqueue Styles in Child Theme
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_enqueue_child_styles')) {
    function inspiry_enqueue_child_styles(){
        if ( !is_admin() ) {
            /* dequeue and deregister parent default styles */
            wp_dequeue_style( 'parent-default' );
            wp_deregister_style( 'parent-default' );

            /* dequeue parent custom css */
            wp_dequeue_style( 'parent-custom' );

            /* enqueue parent default styles */
            wp_enqueue_style( 'parent-default', get_template_directory_uri() . '/style.css' );

            wp_enqueue_style( 'parent-custom' );

            /* enqueue child default styles */
            wp_enqueue_style('child-default', get_stylesheet_uri(), array('parent-default'), '1.0.1', 'all');
            wp_register_script('child-custom-js', get_stylesheet_directory_uri().'/custom-child.js', array(), '1.0', true);
            wp_enqueue_script('child-custom-js');
        }
    }
}
add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_child_styles', PHP_INT_MAX );


/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 *
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 */

function dynamic_section($sections) {
    $sections[] = array(
        'title' => __('ChildTheme Options', 'cream-child'),
        'desc' => __('The section has added config options fro child theme', 'cream-child'),
        'icon' => 'el-icon-paper-clip',
        'fields' => array(
            array(
                'id' => 'top_bar',
                'type' => 'switch',
                'title' => __('Top Bar?', 'framework'),
                'subtitle' => __('Show or Hide top bar', 'framework'),
                'default' => '0',
                'on' => __('Show','framework'),
                'off' => __('Hide','framework')
            ),
            array(
                'id' => 'left_bar_title',
                'type' => 'text',
                'title' => __('Left Bar Title', 'framework'),
                'default' => '',
                'subtitle' => __('Provide title to display above left section on topbar.', 'framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id' => 'left_bar_ico',
                'type' => 'switch',
                'title' => __('Left Bar Icon', 'framework'),
                'default' => '1',
                'subtitle' => __('Provide icon to display above left section on topbar?', 'framework'),
                'on' => __('Yes','framework'),
                'off' => __('No','framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id'       => 'left_bar_info_type',
                'type'     => 'checkbox',
                'title'    => __( 'Content to Show', 'framework' ),
                'subtitle' => __( 'Which information to show in Left Bar.', 'framework' ),
                'options'  => array(
                    'phone' => __('Phone', 'framework'),
                    'address' => __('Address', 'framework'),
                    'mail' => __('Mail', 'framework')
                ),
                'default'  => array(
                    'phone'  => '0',
                    'address'   => '0',
                    'mail' => '1'
                ),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id'=>'left_bar_info_text',
                'type' => 'text',
                'title' => __('Text to link', 'framework'),
                'subtitle' => __('Address/Phone/Mail to display in left top bar ?', 'framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id' => 'right_bar_title',
                'type' => 'text',
                'title' => __('Right Bar Title', 'framework'),
                'default' => '',
                'subtitle' => __('Provide title to display above right section on topbar.', 'framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id' => 'right_bar_ico',
                'type' => 'switch',
                'title' => __('Right Bar Icon', 'framework'),
                'default' => '1',
                'subtitle' => __('Provide icon to display above right section on topbar?', 'framework'),
                'on' => __('Yes','framework'),
                'off' => __('No','framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id'       => 'right_bar_info_type',
                'type'     => 'checkbox',
                'title'    => __( 'Content to Show', 'framework' ),
                'subtitle' => __( 'Which information to show in Right Bar.', 'framework' ),
                'options'  => array(
                    'phone' => __('Phone', 'framework'),
                    'address' => __('Address', 'framework'),
                    'mail' => __('Mail', 'framework')
                ),
                'default'  => array(
                    'phone'  => '1',
                    'address'   => '0',
                    'mail' => '0'
                ),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id'=>'right_bar_info_text',
                'type' => 'text',
                'title' => __('Text to link', 'framework'),
                'subtitle' => __('Address/Phone/Mail to display in right top bar ?', 'framework'),
                'required'  => array('top_bar', '=', '1')
            ),
            array(
                'id'=>'home_services_bg',
                'type'     => 'media',
                'url'      => false,
                'title'    => __('Image background for Home Services Section', 'framework'),
                'subtitle' => __('Upload optional image background to show Home Services Section.', 'framework')
            ),
            array(
                'id' => 'fbk_bar',
                'type' => 'switch',
                'title' => __('Facebook Bar in Footer?', 'framework'),
                'subtitle' => __('Show or Hide fbk bar', 'framework'),
                'default' => '0',
                'on' => __('Show','framework'),
                'off' => __('Hide','framework')
            ),
            array(
                'id' => 'fbk_bar_ico',
                'type' => 'switch',
                'title' => __('Facebook Bar Icon', 'framework'),
                'default' => '1',
                'subtitle' => __('Provide icon to display in Facebook Bar, in footer?', 'framework'),
                'on' => __('Yes','framework'),
                'off' => __('No','framework'),
                'required'  => array('fbk_bar', '=', '1')
            ),
            array(
                'id' => 'fbk_bar_title',
                'type' => 'text',
                'title' => __('Facebook Bar Text', 'framework'),
                'default' => '',
                'subtitle' => __('Provide text to display in Facebook Bar, in footer.', 'framework'),
                'required'  => array('fbk_bar', '=', '1')
            ),
            array(
                'id' => 'fbk_bar_link',
                'type' => 'switch',
                'title' => __('Add link to facebook', 'framework'),
                'subtitle' => __('Select if content make link to facebook page.', 'framework'),
                'default' => '1',
                'on' => __('Show','framework'),
                'off' => __('Hide','framework'),
                'required'  => array('fbk_bar', '=', '1')
            ),
            array(
                'id'       => 'fbk_image',
                'type'     => 'media',
                'url'      => false,
                'title'    => __('Image for Facebook Bar', 'framework'),
                'subtitle' => __('Upload optional image to show in Right Side of the Facebook Bar.', 'framework'),
                'required'  => array('fbk_bar', '=', '1')
            ),
            array(
                'id'    =>'footer_alternative_phone1',
                'type'  =>'text',
                'title' => __('Phone number alternative 1'),
                'subtitle' => __('Phone number alternative 1 to display in footer ?', 'framework'),
                'required'  => array('display_footer_contact_info', '=', '1')
            ),
            array(
                'id'    =>'footer_alternative_phone2',
                'type'  =>'text',
                'title' => __('Phone number alternative 2'),
                'subtitle' => __('Phone number alternative 2 to display in footer ?', 'framework'),
                'required'  => array('display_footer_contact_info', '=', '1')
            )
        )
    );

    return $sections;
}

function woocommerce_template_single_description(){
    echo '<div class="product-desc">';
    the_content();
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_description', 20 );

add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_button_text' , $this );
function custom_button_text (){
    return __( 'Buy', 'cream-child' );
}
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
/**
 * custom_woocommerce_template_loop_add_to_cart
 */
function custom_woocommerce_product_add_to_cart_text() {
    global $product;

    $product_type = $product->product_type;

    switch ( $product_type ) {
        case 'external':
            return __( 'Buy', 'cream-child' );
            break;
        case 'grouped':
            return __( 'Buy', 'cream-child' );
            break;
        case 'simple':
            return __( 'Buy', 'cream-child' );
            break;
        case 'variable':
            return __( 'Buy', 'cream-child' );
            break;
        default:
            return __( 'Read more', 'woocommerce' );
    }

}

remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing', 50);

add_filter('woocommerce_product_tabs', 'woocommerce_remove_reviews_tab', 98);
function woocommerce_remove_reviews_tab($tabs) {
    unset($tabs);
}
function woocommerce_template_single_attr(){
    global $product;
    do_action( 'woocommerce_product_additional_information', $product );
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_attr', 40 );

function my_child_theme_locale() {
    load_child_theme_textdomain( 'cream-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_locale' );