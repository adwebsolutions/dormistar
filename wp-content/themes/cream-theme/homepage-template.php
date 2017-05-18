<?php
/*
 *  Template Name: Homepage Template
 */

global $theme_options;

/* Header */
get_header();


/* Slider */
if ($theme_options['display_slider_on_home'] == '1') {
    if($theme_options['slider_type'] == '2'){
        $revolution_slider_alias = $theme_options['revolution_slider_alias'];
        if( function_exists('putRevSlider') && (!empty($revolution_slider_alias)) ){
            putRevSlider( $revolution_slider_alias );
        } else {
            get_template_part('banners/default-banner');
        }
    }else{
        get_template_part('template-parts/home-slider');
    }
} else {
    get_template_part('banners/default-banner');
}



/* Homepage Layout Manager */
$enabled_sections = $theme_options['home_sections']['enabled'];

if ( $enabled_sections ) {
    foreach ($enabled_sections as $key => $val  ) {

        switch( $key ) {

            /* Features Section */
            case 'features':
                // For Demo Purpose Only
                if( isset( $_GET['features_variation'] ) ){
                    $theme_options['features_variation'] = $_GET['features_variation'];
                }

                // For Real Use
                if( $theme_options['features_variation'] == '2' ){
                    get_template_part('template-parts/home-features-two');
                }else{
                    get_template_part('template-parts/home-features');
                }
                break;

            /* Home page contents from page editor */
            case 'content':
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            $content = get_the_content();
                            if (!empty($content)) {
                                ?>
                                <div class="page-content home-page container">
                                    <div class="row">
                                        <div class="main col-xs-12" role="main">
                                            <article <?php post_class(); ?>>
                                                <div class="entry-content">
                                                    <?php
                                                    /* output page contents */
                                                    the_content();
                                                    ?>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        endwhile;
                    endif;
                break;

            /* Portfolio Section */
            case 'portfolio':
                get_template_part('template-parts/home-portfolio');
                break;

            /* Testimonials Section */
            case 'testimonials':
                get_template_part('template-parts/home-testimonial');
                break;

            /* Services Section */
            case 'services':
                get_template_part('template-parts/home-services');

                break;

            /* News Section */
            case 'news':
                get_template_part('template-parts/home-blog');
                break;

            /* Recent Products */
            case 'recent-products':
                get_template_part('template-parts/home-recent-products');
                break;

            /* Featured Products */
            case 'featured-products':
                get_template_part('template-parts/home-featured-products');
                break;

            /* Sale Products */
            case 'sale-products':
                get_template_part('template-parts/home-sale-products');
                break;

            /* Best Selling Products */
            case 'best-selling-products':
                get_template_part('template-parts/home-best-selling-products');
                break;

            /* Product Categories */
            case 'product-categories':
                get_template_part('template-parts/home-product-categories');
                break;
        }

    }
}


/* Include Footer */
get_footer();
?>