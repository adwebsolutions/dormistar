<?php
/**
 * Cream Theme - Theme Options Config File
 * This file is based on Redux Framework
 * For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Cream_Theme_Redux_Framework_Config')) {

    class Cream_Theme_Redux_Framework_Config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            if( function_exists('dynamic_section') ){
                add_filter('redux/options/' . $this->args['opt_name'] . '/sections', 'dynamic_section');
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }



        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'framework'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'framework'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'framework'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'framework') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'framework'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS

            /*----------------------------------------------------------------------*/
            /* Header Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Header', 'framework'),
                'desc' => __('This section contains options related to website header.', 'framework'),
                'fields' => array(

                    array(
                        'id'       => 'theme_favicon',
                        'type'     => 'media',
                        'url'      => false,
                        'title'    => __('Favicon', 'framework'),
                        'subtitle' => __('Upload a 16px by 16px PNG image that will represent your website favicon.', 'framework')
                    ),
                    array(
                        'id'       => 'website_logo',
                        'type'     => 'media',
                        'url'      => false,
                        'title'    => __('Logo', 'framework'),
                        'subtitle' => __('Upload logo image for your Website. Otherwise site title will be displayed in place of logo.', 'framework')
                    ),
                    array(
                        'id'            => 'main_nav_top_margin',
                        'type'          => 'spacing',
                        'output'        => array( '#menu-main-menu' ), // An array of CSS selectors to apply this font style to
                        'mode'          => 'margin',    // absolute, padding, margin, defaults to padding
                        'all'           => true,        // Have one field that applies to all
                        'right'         => false,     // Disable the right
                        'bottom'        => false,     // Disable the bottom
                        'left'          => false,     // Disable the left
                        'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                        'title'         => __('Top Margin for Main Menu', 'framework'),
                        'desc'      => __('You can provide the top margin for main menu, To make it look well in the middle of your uploaded logo. Simply provide numeric value without px unit.', 'framework'),
                        'default'       => array(
                            'margin-top'    => '0'
                        )
                    ),
                    array(
                        'id'        => 'inspiry_header_search',
                        'type'      => 'switch',
                        'title'     => __('Product Search Form in Header', 'framework'),
                        'default'   => 1,
                        'on'        => __('Show','framework'),
                        'off'       => __('Hide','framework')
                    ),
                    array(
                        'id'       => 'default_page_banner',
                        'type'     => 'media',
                        'url'      => false,
                        'title'    => __('Default Banner Image', 'framework'),
                        'desc'     => __('Banner image should have minimum width of 2000px and minimum height of 190px.', 'framework'),
                        'subtitle' => __('Default banner image will be displayed on all the pages where banner image is not overridden by page specific banner settings.', 'framework')
                    ),
                    array(
                        'id'        => 'display_wpml_flags',
                        'type'      => 'switch',
                        'title'     => __('WPML Language Switcher Flags', 'framework'),
                        'subtitle'     => __('Do you want to display WPML language switcher flags in header top bar ?', 'framework'),
                        'desc'     => __('This option only works if WPML plugin is installed.', 'framework'),
                        'default'   => 1,
                        'on'        => __('Show','framework'),
                        'off'       => __('Hide','framework')
                    ),
                    array(
                        'id'        => 'quick_js',
                        'type'      => 'ace_editor',
                        'title'     => __('Quick JavaScript', 'framework'),
                        'desc'  => __('You can paste your JavaScript code here.', 'framework'),
                        'mode'      => 'javascript',
                        'theme'     => 'chrome'
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Section - Slider & Appointment
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home', 'framework'),
                'icon'    => 'el-icon-home-alt',
                'desc' => __('This section contains options related to website homepage.', 'framework'),
                'fields' => array(

                    /* Homepage Slider Section */
                    array(
                        'id'       => 'display_slider_on_home',
                        'type'     => 'switch',
                        'title'    => __('Homepage Slider', 'framework'),
                        'subtitle' => __('Do you want to display slider on homepage ?', 'framework'),
                        'desc'     => __('Image banner will be displayed if slider is disabled', 'framework'),
                        'default'  => '1',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework')
                    ),
                    array(
                        'id'        => 'slider_type',
                        'type'      => 'button_set',
                        'title'     => __('Slider Type', 'framework'),
                        'subtitle'  => __('Select the type of slider that you want to use.', 'framework'),
                        'options'   => array(
                            '1' => __('Default Slider','framework'),
                            '2' => __('Revolution Slider','framework')
                        ),
                        'default'   => '1',
                        'required'  => array( 'display_slider_on_home', '=', '1' )
                    ),
                    array(
                        'id' => 'revolution_slider_alias',
                        'type' => 'text',
                        'title' => __('Revolution Slider Alias', 'framework'),
                        'subtitle' => __('If you want to use revolution slider then provide its alias here.', 'framework'),
                        'desc' => __('For more information consult documentation.', 'framework'),
                        'required'  => array('slider_type', '=', '2')
                    ),
                    array(
                        'id' => 'slides',
                        'type' => 'slides',
                        'title' => __('Homepage Slider Slides', 'framework'),
                        'subtitle' => __('Add slides for homepage slider.', 'framework'),
                        'desc' => __('The recommended image size is 2000px by 800px. You can use bigger or smaller image size but try to keep the width to height ratio 100px to 40px and use the exactly same size images for all slides.', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Slide title text', 'framework'),
                            'description' => __('Slide description text', 'framework'),
                            'url' => __('Provide URL for button', 'framework')
                        ),
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id'       => 'slide_desc_position',
                        'type'     => 'select',
                        'title'    => __('Slide contents position from top', 'framework'),
                        'subtitle' => __('Change the slide contents position from top in %age', 'framework'),
                        'options'  => array(
                            '30' => '30%',
                            '40' => '40%',
                            '50' => '50%',
                            '60' => '60%',
                            '70' => '70%',
                            '80' => '80%'
                        ),
                        'default'  => '60',
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id'       => 'display_slide_bg',
                        'type'     => 'switch',
                        'title'    => __('Slide Contents Background', 'framework'),
                        'subtitle' => __('Do you want to display a light background behind slide contents ?', 'framework'),
                        'default'  => '0',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework'),
                        'required'  => array( 'slider_type', '=', '1' )
                    ),
                    array(
                        'id'        => 'slide_heading_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('.home-slider .slide-description h2'),
                        'title'     => __('Slide Heading Color', 'framework'),
                        'desc'  => 'default: #ffffff',
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id'        => 'slide_desc_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('.home-slider .slide-description p'),
                        'title'     => __('Slide Description Color', 'framework'),
                        'desc'  => 'default: #131313',
                        'default'   => '#131313',
                        'validate'  => 'color',
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id'        => 'slide_button_color',
                        'type'      => 'link_color',
                        'title'     => __('Slide Button Text Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.home-slider .slide-description a' ),
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        ),
                        'required'  => array('slider_type', '=', '1')
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'slide_button_bg',
                        'type'      => 'link_color',
                        'title'     => __('Slide Button Background Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#282424',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        ),
                        'required'  => array('slider_type', '=', '1')
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'slider_arrow_bg',
                        'type'      => 'link_color',
                        'title'     => __('Slider Arrows Background Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#282424',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        ),
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id'      => 'home_sections',
                        'type'    => 'sorter',
                        'title'   => __('Homepage Layout Manager', 'framework'),
                        'desc'    => __('Organize homepage sections, The way you want them to appear.', 'framework'),
                        'options' => array(
                            'enabled'  => array(
                                'features' => __('Features', 'framework'),
                                'content' => __('Content', 'framework'),
                                'portfolio'     => __('Portfolio', 'framework'),
                                'testimonials' => __('Testimonials', 'framework'),
                                'services'   => __('Services', 'framework'),
                                'news'   => __('News', 'framework')
                            ),
                            'disabled' => array(
                                'recent-products' => __('Recent Products', 'framework'),
                                'featured-products' => __('Feature Products', 'framework'),
                                'sale-products' => __('Sale Products', 'framework'),
                                'best-selling-products' => __('Best Selling Prod-', 'framework'),
                                'product-categories' => __('Product Categori-', 'framework')
                            )
                        )
                    )

                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Features Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Features', 'framework'),
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'home_features_title',
                        'type' => 'text',
                        'title' => __('Features Title', 'framework'),
                        'default' => 'Business Features',
                        'subtitle' => __('Provide title to display above features section on homepage.', 'framework')
                    ),
                    array(
                        'id' => 'home_features_description',
                        'type' => 'textarea',
                        'title' => __('Features Description', 'framework'),
                        'default' => 'Some description text about features',
                        'subtitle' => __('Provide the text description to display below title in features section on homepage.', 'framework'),
                        'validate' => 'no_html'
                    ),
                    array(
                        'id'        => 'features_variation',
                        'type'      => 'image_select',
                        'title'     => __('Features Section Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for features on homepage.', 'framework'),
                        'options'   => array(
                            '1' => array('title' => __('1st Variation', 'framework'), 'img' => get_template_directory_uri().'/images/theme-options/features_variation_1.png'),
                            '2' => array('title' => __('2nd Variation', 'framework'), 'img' => get_template_directory_uri().'/images/theme-options/features_variation_2.png')
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id' => 'home_features',
                        'type' => 'slides',
                        'title' => __('Features', 'framework'),
                        'subtitle' => __('Keep the maximum height and maximum width of feature image below 120px', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Feature Title', 'framework'),
                            'description' => __('Feature Description', 'framework'),
                            'url' => __('Feature link if any', 'framework')
                        ),
                        'content_title' => 'Feature',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'home_features_2',
                        'type' => 'slides',
                        'title' => __('Features', 'framework'),
                        'subtitle' => __('Recommended size for feature image is 172px by 172px', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Feature Title', 'framework'),
                            'description' => __('Feature Description', 'framework'),
                            'url' => __('Feature link if any', 'framework')
                        ),
                        'content_title' => 'Feature',
                        'required'  => array( 'features_variation', '=', '2' )
                    ),
                    array(
                        'id'       => 'display_curve',
                        'type'     => 'switch',
                        'title'    => __('Curved Area', 'framework'),
                        'subtitle' => __('Do you want to display curved area above features section on homepage ?', 'framework'),
                        'default'  => '1',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    $fields = array(
                        'id'        => 'curve_height',
                        'type'      => 'slider',
                        'title'     => __('Curved Area Height', 'framework'),
                        "default"   => 110,
                        "min"       => 80,
                        "step"      => 1,
                        "max"       => 170,
                        'display_value' => 'label',
                        'required'  => array( 'display_curve', '=', '1' )
                    ),
                    array(
                        'id'        => 'features_background',
                        'type'      => 'color',
                        'output'    => array(
                                        'background-color' => '.home-services-section .section-top'
                                        ),
                        'title'     => __('Features Section Background Color', 'framework'),
                        'desc'     => 'default: #66d9c1',
                        'default'   => '#66d9c1',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id'        => 'features_title_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-services-section .section-header .section-title'
                        ),
                        'title'     => __('Features Title Color', 'framework'),
                        'desc'     => 'default: #ffffff',
                        'default'   => '#ffffff',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id'        => 'features_desc_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-services-section .section-header p'
                        ),
                        'title'     => __('Features Description Color', 'framework'),
                        'desc'     => 'default: #357165',
                        'default'   => '#357165',
                        'required'  => array( 'features_variation', '=', '1' )
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Portfolio Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Portfolio', 'framework'),
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'home_portfolio_title',
                        'type' => 'text',
                        'title' => __('Portfolio Title', 'framework'),
                        'default' => 'Our Work',
                        'subtitle' => __('Provide title to display above portfolio section on homepage.', 'framework')
                    ),
                    array(
                        'id' => 'home_portfolio_description',
                        'type' => 'textarea',
                        'title' => __('Portfolio Description', 'framework'),
                        'default' => 'Some description text about work',
                        'subtitle' => __('Provide the text description to display below title in portfolio section on homepage.', 'framework'),
                        'validate' => 'no_html',
                    ),
                    array(
                        'id'       => 'home_portfolio_rows',
                        'type'     => 'select',
                        'title'    => __('Portfolio Rows', 'framework'),
                        'subtitle' => __('Select the number of rows for portfolio items in portfolio section on homepage', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4'
                        ),
                        'default'  => '1',
                    ),
                    array(
                        'id'       => 'home_portfolio_number_of_items',
                        'type'     => 'select',
                        'title'    => __('Number of Portfolio Items', 'framework'),
                        'subtitle' => __('Select the maximum number of portfolio items to display in portfolio section on homepage', 'framework'),
                        'options'  => array(
                            '-1' => 'All',
                            '4' => '4',
                            '6' => '6',
                            '8' => '8',
                            '10' => '10',
                            '12' => '12',
                            '14' => '14',
                            '16' => '16',
                            '18' => '18'
                        ),
                        'default'  => '-1',
                    ),
                    array(
                        'id'       => 'home_portfolio_order_by',
                        'type'     => 'select',
                        'title'    => __('Order By', 'framework'),
                        'subtitle' => __('Select the sorting criteria for portfolio items.', 'framework'),
                        'options'  => array(
                            'date' => 'Date',
                            'title' => 'Title',
                            'rand' => 'Random'
                        ),
                        'default'  => 'date'
                    ),
                    array(
                        'id'       => 'home_portfolio_order',
                        'type'     => 'select',
                        'title'    => __('Order', 'framework'),
                        'subtitle' => __('Select the sort order for portfolio items.', 'framework'),
                        'options'  => array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending'
                        ),
                        'default'  => 'DESC'
                    ),
                    array(
                        'id'        => 'portfolio_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.home-work-section'
                        ),
                        'title'     => __('Portfolio Section Background Color', 'framework'),
                        'desc'     => 'default: #faf8f4',
                        'default'   => '#faf8f4'
                    ),
                    array(
                        'id'        => 'portfolio_title_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-work-section .section-title'
                        ),
                        'title'     => __('Portfolio Title Color', 'framework'),
                        'desc'     => 'default: #3a4543',
                        'default'   => '#3a4543'
                    ),
                    array(
                        'id'        => 'portfolio_desc_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-work-section .section-header p'
                        ),
                        'title'     => __('Portfolio Description Color', 'framework'),
                        'desc'     => 'default: #969d9b',
                        'default'   => '#969d9b'
                    )
                )
            );

            /*----------------------------------------------------------------------*/
            /* Home Testimonials Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Testimonials', 'framework'),
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'home_testimonials_title',
                        'type' => 'text',
                        'title' => __('Testimonials Title', 'framework'),
                        'default' => 'Client Testimonials',
                        'subtitle' => __('Provide the title text to display above testimonials on homepage.', 'framework')
                    ),
                    array(
                        'id' => 'home_testimonials_description',
                        'type' => 'textarea',
                        'title' => __('Testimonials Description', 'framework'),
                        'default' => 'Some description text about testimonials',
                        'subtitle' => __('Provide the text description to display below title in testimonials section on homepage.', 'framework'),
                        'validate' => 'no_html'
                    ),
                    array(
                        'id'       => 'home_number_of_testimonials',
                        'type'     => 'select',
                        'title'    => __('Number of Testimonials', 'framework'),
                        'subtitle' => __('Select the maximum number of testimonials to display on homepage', 'framework'),
                        'options'  => array(
                            '-1' => 'All',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9'
                        ),
                        'default'  => '-1'
                    ),
                    array(
                        'id'       => 'home_testimonial_order_by',
                        'type'     => 'select',
                        'title'    => __('Order By', 'framework'),
                        'subtitle' => __('Select the sorting criteria for testimonials.', 'framework'),
                        'options'  => array(
                            'date' => 'Date',
                            'rand' => 'Random'
                        ),
                        'default'  => 'date'
                    ),
                    array(
                        'id'        => 'testimonial_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.home-testimonial-section'
                        ),
                        'title'     => __('Testimonial Section Background Color', 'framework'),
                        'desc'     => 'default: #ffffff',
                        'default'   => '#ffffff'
                    ),
                    array(
                        'id'        => 'testimonial_title_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-testimonial-section .section-title'
                        ),
                        'title'     => __('Testimonial Title Color', 'framework'),
                        'desc'     => 'default: #3a4543',
                        'default'   => '#3a4543'
                    ),
                    array(
                        'id'        => 'testimonial_desc_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-testimonial-section .section-header p'
                        ),
                        'title'     => __('Testimonial Description Color', 'framework'),
                        'desc'     => 'default: #969d9b',
                        'default'   => '#969d9b'
                    ),
                    array(
                        'id'        => 'testimonial_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-testimonial-section .testimonial-text p'
                        ),
                        'title'     => __('Testimonial Text Color', 'framework'),
                        'desc'     => 'default: #7f8281',
                        'default'   => '#7f8281'
                    ),
                    array(
                        'id'        => 'testimonial_author_color',
                        'type'      => 'link_color',
                        'title'     => __('Testimonial Author Name Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.home-testimonial-section .testimonial-text a, .home-testimonial-section .testimonial-text cite' ),
                        'default'   => array(
                            'regular'   => '#66d9c1',
                            'hover'     => '#3a4543',
                            'active'     => '#3a4543'
                        )
                    ),
                    array(
                        'id'        => 'testimonial_arrow_bg',
                        'type'      => 'link_color',
                        'title'     => __('Testimonial Arrows Background Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#282424',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        )
                    ),
                    array(
                        'id'        => 'testimonial_border_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'border-color' => '.home-testimonial-section .testimonial-carousel',
                            'background-color' => '.home-testimonial-section .vertical-line'
                        ),
                        'title'     => __('Testimonial Border Color', 'framework'),
                        'desc'     => 'default: #f1f1f1',
                        'default'   => '#f1f1f1'
                    ),
                    array(
                        'id'        => 'testimonial_image_border_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'border-color' => '.home-testimonial-section .img-frame'
                        ),
                        'title'     => __('Testimonial Image Border Color', 'framework'),
                        'desc'     => 'default: #d6d6d6',
                        'default'   => '#d6d6d6'
                    ),
                    array(
                        'id'        => 'testimonial_image_bg',
                        'type'      => 'link_color',
                        'title'     => __('Testimonial Image Background Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#ddf5f1',
                            'hover'     => '#fdeac2'
                        )
                    ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Services Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Services', 'framework'),
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'home_services_title',
                        'type' => 'text',
                        'title' => __('Services Title', 'framework'),
                        'default' => 'Our Services',
                        'subtitle' => __('Provide the title to display above services section on homepage.', 'framework')
                    ),
                    array(
                        'id' => 'home_services_description',
                        'type' => 'textarea',
                        'title' => __('Services Description', 'framework'),
                        'default' => 'Some description text about services',
                        'subtitle' => __('Provide the text description to display below title in services section on homepage.', 'framework'),
                        'validate' => 'no_html'
                    ),
                    array(
                        'id' => 'home_services',
                        'type' => 'slides',
                        'title' => __('Services', 'framework'),
                        'subtitle' => __('You can upload image of any size. Recommended image size is 320px x 194px. Make sure to upload all images of same size.', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Service Title', 'framework'),
                            'description' => __('Service Description', 'framework'),
                            'url' => __('Service link if any', 'framework')
                        ),
                        'content_title' => 'Service'
                    ),
                    array(
                        'id'        => 'services_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.service-plans'
                        ),
                        'title'     => __('Services Section Background Color', 'framework'),
                        'desc'     => 'default: #f9ca67',
                        'default'   => '#f9ca67'
                    ),
                    array(
                        'id'       => 'services_background_image',
                        'type'     => 'switch',
                        'title'    => __('Services Section Background Image', 'framework'),
                        'subtitle' => __('Do you want to display background images in services section. ?', 'framework'),
                        'default'  => '1',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework')
                    ),
                    array(
                        'id'        => 'services_title_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.service-plans .section-title'
                        ),
                        'title'     => __('Services Title Color', 'framework'),
                        'desc'     => 'default: #3a4543',
                        'default'   => '#3a4543'
                    ),
                    array(
                        'id'        => 'services_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.service-plans p'
                        ),
                        'title'     => __('Services Text Color', 'framework'),
                        'desc'     => 'default: #ffffff',
                        'default'   => '#ffffff'
                    ),
                    array(
                        'id'        => 'services_heading_color',
                        'type'      => 'link_color',
                        'title'     => __('Services Heading Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.service-plans .title a' ),
                        'default'   => array(
                            'regular'   => '#3a4543',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        )
                    ),
                    array(
                        'id'        => 'services_image_bg',
                        'type'      => 'link_color',
                        'title'     => __('Services Image Background Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#fad382',
                            'hover'     => '#fce3b0'
                        )
                    )

                )
            );


            /*----------------------------------------------------------------------*/
            /* Home News Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - News', 'framework'),
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'home_news_title',
                        'type' => 'text',
                        'title' => __('News Title', 'framework'),
                        'default' => 'Latest News',
                        'subtitle' => __('Provide title to display above news section on homepage.', 'framework')
                    ),
                    array(
                        'id' => 'home_news_description',
                        'type' => 'textarea',
                        'title' => __('News Description', 'framework'),
                        'default' => 'Some description text about latest news',
                        'subtitle' => __('Provide the text description to display below title in news section on homepage.', 'framework'),
                        'validate' => 'no_html'
                    ),
                    array(
                        'id'       => 'home_number_of_news_items',
                        'type'     => 'select',
                        'title'    => __('Number of News Items', 'framework'),
                        'subtitle' => __('Select the maximum number of news items to display in news section on homepage', 'framework'),
                        'options'  => array(
                            '-1' => 'All',
                            '3' => '3',
                            '6' => '6',
                            '9' => '9',
                            '12' => '12',
                            '15' => '15'
                        ),
                        'default'  => '6'
                    ),
                    array(
                        'id'       => 'home_news_order_by',
                        'type'     => 'select',
                        'title'    => __('Order By', 'framework'),
                        'subtitle' => __('Select the sorting criteria for news items.', 'framework'),
                        'options'  => array(
                            'date' => 'Date',
                            'title' => 'Title',
                            'rand' => 'Random'
                        ),
                        'default'  => 'date'
                    ),
                    array(
                        'id'       => 'home_news_order',
                        'type'     => 'select',
                        'title'    => __('Order', 'framework'),
                        'subtitle' => __('Select the sort order for news items.', 'framework'),
                        'options'  => array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending'
                        ),
                        'default'  => 'DESC'
                    ),
                    array(
                        'id'        => 'news_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.home-blog-section'
                        ),
                        'title'     => __('News Section Background Color', 'framework'),
                        'desc'     => 'default: #ffffff',
                        'default'   => '#ffffff'
                    ),
                    array(
                        'id'        => 'news_title_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-blog-section .section-title'
                        ),
                        'title'     => __('News Title Color', 'framework'),
                        'desc'     => 'default: #3a4543',
                        'default'   => '#3a4543'
                    ),
                    array(
                        'id'        => 'news_desc_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.home-blog-section .section-header p'
                        ),
                        'title'     => __('News Description Color', 'framework'),
                        'desc'     => 'default: #969d9b',
                        'default'   => '#969d9b'
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home News Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Shop', 'framework'),
                'subsection' => true,
                'fields' => array(

                    /* Recent Products */
                    array(
                        'id' => 'recent_products_title',
                        'type' => 'text',
                        'title' => __('Recent Products Title', 'framework'),
                        'default'  => __('Recent Products', 'framework'),
                        'subtitle' => __('Provide the title for recent products section on homepage.', 'framework')
                    ),
                    array(
                        'id'       => 'recent_columns',
                        'type'     => 'select',
                        'title'    => __('Recent Products Columns', 'framework'),
                        'subtitle' => __('Select the number of columns for recent products.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '6' => '6'
                        ),
                        'default'  => '4'
                    ),
                    array(
                        'id'       => 'recent_rows',
                        'type'     => 'select',
                        'title'    => __('Recent Products Rows', 'framework'),
                        'subtitle' => __('Select the number of rows for recent products.', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '1'
                    ),

                    /* Featured Products */
                    array(
                        'id' => 'featured_products_title',
                        'type' => 'text',
                        'title' => __('Featured Products Title', 'framework'),
                        'default'  => __('Featured Products', 'framework'),
                        'subtitle' => __('Provide the title for featured products section on homepage.', 'framework')
                    ),
                    array(
                        'id'       => 'featured_columns',
                        'type'     => 'select',
                        'title'    => __('Featured Products Columns', 'framework'),
                        'subtitle' => __('Select the number of columns for featured products.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '6' => '6'
                        ),
                        'default'  => '4'
                    ),
                    array(
                        'id'       => 'featured_rows',
                        'type'     => 'select',
                        'title'    => __('Featured Products Rows', 'framework'),
                        'subtitle' => __('Select the number of rows for featured products.', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '1'
                    ),

                    /* Sale Products */
                    array(
                        'id' => 'sale_products_title',
                        'type' => 'text',
                        'title' => __('Sale Products Title', 'framework'),
                        'default'  => __('Sale Products', 'framework'),
                        'subtitle' => __('Provide the title for sale products section on homepage.', 'framework')
                    ),
                    array(
                        'id'       => 'sale_columns',
                        'type'     => 'select',
                        'title'    => __('Sale Products Columns', 'framework'),
                        'subtitle' => __('Select the number of columns for sale products.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '6' => '6'
                        ),
                        'default'  => '4'
                    ),
                    array(
                        'id'       => 'sale_rows',
                        'type'     => 'select',
                        'title'    => __('Sale Products Rows', 'framework'),
                        'subtitle' => __('Select the number of rows for sale products.', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '1'
                    ),

                    /* Best Selling Products */
                    array(
                        'id' => 'best_selling_products_title',
                        'type' => 'text',
                        'title' => __('Best Selling Products Title', 'framework'),
                        'default'  => __('Best Selling Products', 'framework'),
                        'subtitle' => __('Provide the title for best selling products section on homepage.', 'framework')
                    ),
                    array(
                        'id'       => 'best_selling_columns',
                        'type'     => 'select',
                        'title'    => __('Best Selling Products Columns', 'framework'),
                        'subtitle' => __('Select the number of columns for best selling products.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '6' => '6'
                        ),
                        'default'  => '4'
                    ),
                    array(
                        'id'       => 'best_selling_rows',
                        'type'     => 'select',
                        'title'    => __('Best Selling Products Rows', 'framework'),
                        'subtitle' => __('Select the number of rows for best selling products.', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '1'
                    ),

                    /* Product Categories */
                    array(
                        'id' => 'product_categories_title',
                        'type' => 'text',
                        'title' => __('Product Categories Title', 'framework'),
                        'default'  => __('Product Categories', 'framework'),
                        'subtitle' => __('Provide the title for product categories section on homepage.', 'framework')
                    ),
                    array(
                        'id'       => 'number_of_categories',
                        'type'     => 'select',
                        'title'    => __('Number of Categories', 'framework'),
                        'subtitle' => __('Select the number of product categories to display on homepage.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '8' => '8',
                            '12' => '12',
                            '16' => '16',
                            '20' => '20'
                        ),
                        'default'  => '4'
                    ),
                    array(
                        'id'          => 'product_category_ids',
                        'type'        => 'select',
                        'multi'       => true,
                        'title'       => __( 'Product Categories', 'framework' ),
                        'subtitle'    => __( 'Select the product categories to display on homepage.', 'framework' ),
                        'description' => __( 'Leave empty if you want to show product categories by default.', 'framework' ),
                        'data' => 'terms',
                        'args' => array( 'taxonomies'=>'product_cat', 'args'=>array() )
                    )

                )
            );



            /*----------------------------------------------------------------------*/
            /* Shop related theme options
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Shop', 'framework'),
                'icon'    => 'el-icon-shopping-cart-sign',
                'heading' => __('Shop', 'framework'),
                'desc' => __('This section contains theme options related to WooCommerce Shop.', 'framework'),
                'fields' => array(
                    array(
                        'id'        => 'shop_layout',
                        'type'      => 'button_set',
                        'title'     => __('Shop Layout', 'framework'),
                        'subtitle'  => __('Select the type of layout that you want to use for shop.', 'framework'),
                        'options'   => array(
                            'right-sidebar' => __('Right Sidebar','framework'),
                            'full-width' => __('Full Width','framework'),
                            'left-sidebar' => __('Left Sidebar','framework')
                        ),
                        'default'   => 'right-sidebar'
                    ),
                    array(
                        'id'       => 'products_per_page',
                        'type'     => 'select',
                        'title'    => __('Number of Products Per Page', 'framework'),
                        'subtitle' => __('Select the maximum number of products that you want to display on a shop page.', 'framework'),
                        'options'  => array(
                            '4' => '4',
                            '6' => '6',
                            '8' => '8',
                            '9' => '9',
                            '12' => '12',
                            '15' => '15',
                            '16' => '16',
                            '18' => '18',
                            '20' => '20',
                            '21' => '21',
                        ),
                        'default'  => '12',
                    ),
                    array(
                        'id'       => 'product_share_icons',
                        'type'     => 'checkbox',
                        'title'    => __( 'Product Social Share Icons', 'framework' ),
                        'subtitle' => __( 'Which social share icons you want to display on product detail page.', 'framework' ),
                        'options'  => array(
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'pinterest' => 'Pinterest',
                            'googleplus' => 'Google Plus'
                        ),
                        'default'  => array(
                            'facebook'  => '1',
                            'twitter'   => '1',
                            'pinterest' => '1',
                            'googleplus'=> '1'
                        )
                    ),
                    array(
                        'id'        => 'display_cart_in_header',
                        'type'      => 'switch',
                        'title'     => __('Quick View Cart Link', 'framework'),
                        'subtitle'     => __('Do you want to display quick view cart link in header ?', 'framework'),
                        'default'   => 1,
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework')
                    ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Gallery Detail Page
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Gallery Item', 'framework'),
                'icon'    => 'el-icon-photo-alt',
                'heading' => __('Gallery Item Detail Page', 'framework'),
                'desc' => __('This section contains options related to gallery detail page.', 'framework'),
                'fields' => array(

                    array(
                        'id' => 'display_related_gallery_items',
                        'type' => 'switch',
                        'title' => __('Related Gallery Items', 'framework'),
                        'subtitle' => __('Do you want to display related gallery items section on gallery detail page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'related_gallery_items_title',
                        'type' => 'text',
                        'title' => __('Related Gallery Items Title', 'framework'),
                        'subtitle' => __('Provide the title text to display above related gallery items section.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                        'required'  => array('display_related_gallery_items', '=', '1'),
                        'default' => __('Related Gallery Items', 'framework')
                    ),
                    array(
                        'id'=>'related_gallery_items_description',
                        'type' => 'textarea',
                        'title' => __(' Related Gallery Items Description', 'framework'),
                        'default' => 'Some description text about related gallery items',
                        'subtitle' => __('Provide the text description to display below title in related gallery items section.', 'framework'),
                        'required'  => array('display_related_gallery_items', '=', '1'),
                        'validate' => 'no_html'
                    )
                ),
            );


            /*----------------------------------------------------------------------*/
            /*  Contact Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Contact  ', 'framework'),
                'icon'    => 'el-icon-envelope-alt',
                'desc' => __('This section contains options related to contact page.', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'display_contact_form',
                        'type' => 'switch',
                        'title' => __('Contact Form', 'framework'),
                        'subtitle' => __('Do you want to display contact form on contact page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'contact_form_title',
                        'type' => 'text',
                        'title' => __('Contact Form Title', 'framework'),
                        'default' => __('Send a Message', 'framework'),
                        'required'  => array('display_contact_form', '=', '1')
                    ),
                    array(
                        'id' => 'contact_email',
                        'type' => 'text',
                        'title' => __('Contact Form Email', 'framework'),
                        'default' => get_option('admin_email'),
                        'subtitle' => __('Provide the email address where you want to receive contact form messages.', 'framework'),
                        'required' => array('display_contact_form', '=', '1'),
                        'validate' => 'email'
                    ),
                    array(
                        'id' => 'display_contact_details',
                        'type' => 'switch',
                        'title' => __('Other Contact Details', 'framework'),
                        'subtitle' => __('Do you want to display other contact details like address and phone numbers in sidebar ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'contact_details_title',
                        'type' => 'text',
                        'default' => __('Address', 'framework'),
                        'required'  => array('display_contact_details', '=', '1'),
                        'title' => __('Contact Details Title', 'framework')
                    ),
                    array(
                        'id'=>'contact_address',
                        'type' => 'textarea',
                        'title' => __('Address', 'framework'),
                        'desc' => __('HTML is allowed', 'framework'),
                        'required'  => array('display_contact_details', '=', '1'),
                        'validate' => 'html'
                    ),
                    array(
                        'id'=>'contact_phone_01',
                        'type' => 'text',
                        'title' => __('1st Phone Number', 'framework'),
                        'required'  => array('display_contact_details', '=', '1')
                    ),
                    array(
                        'id'=>'contact_phone_02',
                        'type' => 'text',
                        'title' => __('2nd Phone Number', 'framework'),
                        'required'  => array('display_contact_details', '=', '1')
                    ),
                    array(
                        'id'=>'contact_fax',
                        'type' => 'text',
                        'title' => __('Fax Number', 'framework'),
                        'required'  => array('display_contact_details', '=', '1')
                    ),
                    array(
                        'id' => 'display_google_map',
                        'type' => 'switch',
                        'title' => __('Google Map', 'framework'),
                        'subtitle' => __('Do you want to display google map on contact page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'google_maps_api_key',
                        'type' => 'text',
                        'title' => __('Google Maps API Key', 'framework'),
                        'required'  => array('display_google_map', '=', '1')
                    ),
                    array(
                        'id'=>'google_map_latitude',
                        'type' => 'text',
                        'title' => __('Google Map Latitude', 'framework'),
                        'default'   => '-37.817209',
                        'desc' => 'Latitude and longitude of a point can be obtained from <a target="_blank" href="http://itouchmap.com/latlong.html">following site</a>',
                        'required'  => array('display_google_map', '=', '1')
                    ),
                    array(
                        'id'=>'google_map_longitude',
                        'type' => 'text',
                        'title' => __('Google Map Longitude', 'framework'),
                        'default'   => '144.965108',
                        'required'  => array('display_google_map', '=', '1')
                    ),
                    array(
                        'id'=>'google_map_zoom',
                        'type' => 'text',
                        'validate'  => 'numeric',
                        'title' => __('Google Map Zoom', 'framework'),
                        'default'   => '16',
                        'required'  => array('display_google_map', '=', '1')
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Footer Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Footer', 'framework'),
                'desc' => __('This section contains footer related options.', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'display_tweet_above_footer',
                        'type' => 'switch',
                        'title' => __('Latest Tweet Above Footer', 'framework'),
                        'subtitle' => __('Do you want to display latest tweet above footer ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'        => 'twitter_notice',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'info',
                        'icon'      => '',
                        'title'     => __('Note', 'framework'),
                        'desc'      => 'Now, you need the twitter application consumer key, consumer secret, access token and access token secret for twitter authentication. To get all these keys, You need to register a new twitter app from <a target="_blank" href="https://apps.twitter.com/app/new">following url</a> After registering app and generating access token you will have api keys and access token as required below',
                        'required'  => array( 'display_tweet_above_footer', '=', '1' )
                    ),
                    array(
                        'id'=>'twitter_username',
                        'type' => 'text',
                        'title' => __('Twitter Username', 'framework'),
                        'subtitle' => __('Provide twitter username', 'framework'),
                        'required'  => array('display_tweet_above_footer', '=', '1')
                    ),
                    array(
                        'id'=>'consumer_key',
                        'type' => 'text',
                        'title' => __('Consumer Key', 'framework'),
                        'required'  => array('display_tweet_above_footer', '=', '1')
                    ),
                    array(
                        'id'=>'consumer_secret',
                        'type' => 'text',
                        'title' => __('Consumer Secret', 'framework'),
                        'required'  => array('display_tweet_above_footer', '=', '1')
                    ),
                    array(
                        'id'=>'access_token',
                        'type' => 'text',
                        'title' => __('Access Token', 'framework'),
                        'required'  => array('display_tweet_above_footer', '=', '1')
                    ),
                    array(
                        'id'=>'access_token_secret',
                        'type' => 'text',
                        'title' => __('Access Token Secret', 'framework'),
                        'required'  => array('display_tweet_above_footer', '=', '1')
                    ),
                    array(
                        'id' => 'display_footer_contact_info',
                        'type' => 'switch',
                        'title' => __('Contact Information in Footer', 'framework'),
                        'subtitle' => __('Do you want to display contact information in footer ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'footer_address',
                        'type' => 'text',
                        'title' => __('Address', 'framework'),
                        'subtitle' => __('Address to display in footer ?', 'framework'),
                        'required'  => array('display_footer_contact_info', '=', '1')
                    ),
                    array(
                        'id'=>'footer_phone',
                        'type' => 'text',
                        'title' => __('Phone Number', 'framework'),
                        'subtitle' => __('Phone number to display in footer ?', 'framework'),
                        'required'  => array('display_footer_contact_info', '=', '1')
                    ),
                    array(
                        'id'=>'footer_email',
                        'type' => 'text',
                        'title' => __('Email', 'framework'),
                        'subtitle' => __('Email address to display in footer ?', 'framework'),
                        'required'  => array('display_footer_contact_info', '=', '1')
                    ),


                    array(
                        'id' => 'display_footer_social_icons',
                        'type' => 'switch',
                        'title' => __('Social Icons', 'framework'),
                        'subtitle' => __('Do you want to display social icons in footer ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'social_icons_title',
                        'type' => 'text',
                        'title' => __('Social Icons Title', 'framework'),
                        'default' => __('Get Social With Us', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'skype_username',
                        'type' => 'text',
                        'title' => __('Skype Username', 'framework'),
                        'subtitle' => __('Provide skype username to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'twitter_url',
                        'type' => 'text',
                        'title' => __('Twitter', 'framework'),
                        'subtitle' => __('Provide twitter url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'facebook_url',
                        'type' => 'text',
                        'title' => __('Facebook', 'framework'),
                        'subtitle' => __('Provide facebook url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'google_url',
                        'type' => 'text',
                        'title' => __('Google+', 'framework'),
                        'subtitle' => __('Provide google+ url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'linkedin_url',
                        'type' => 'text',
                        'title' => __('LinkedIn', 'framework'),
                        'subtitle' => __('Provide LinkedIn url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'instagram_url',
                        'type' => 'text',
                        'title' => __('Instagram', 'framework'),
                        'subtitle' => __('Provide Instagram url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'youtube_url',
                        'type' => 'text',
                        'title' => __('YouTube', 'framework'),
                        'subtitle' => __('Provide YouTube url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'rss_url',
                        'type' => 'text',
                        'title' => __('RSS', 'framework'),
                        'subtitle' => __('Provide RSS feed url to display its icon.', 'framework'),
                        'required'  => array('display_footer_social_icons', '=', '1')
                    ),
                    array(
                        'id'=>'footer_copyright',
                        'type' => 'text',
                        'title' => __('Copyright Text', 'framework')
                    ),
                    array(
                        'id' => 'display_scroll_top',
                        'type' => 'switch',
                        'title' => __('Scroll Top', 'framework'),
                        'subtitle' => __('Do you want to display scroll top arrow in footer ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    )
                )

            );


            /*----------------------------------------------------------------------*/
            /* Styling Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Styling', 'framework'),
                'icon'      => 'el-icon-website',
                'desc' => __('This section contains styles related options.', 'framework'),
                'fields' => array(
                     array(
                        'id'        => 'body_background',
                        'type'      => 'background',
                        'output'    => array( 'body' ),
                        'title'     => __('Body Background', 'framework'),
                        'subtitle'     => __('Configure body background of your choice. ( default:#ffffff )', 'framework'),
                        'default'   => '#ffffff'
                    ),
                    array(
                        'id' => 'animation',
                        'type' => 'switch',
                        'title' => __('Animation?', 'framework'),
                        'subtitle' => __('Enable or Disable CSS3 animation on various components', 'framework'),
                        'default' => '1',
                        'on' => __('Enabled','framework'),
                        'off' => __('Disabled','framework')
                    ),
                    array(
                        'id' => 'want_to_change_fonts',
                        'type' => 'switch',
                        'title' => __('Do you want to change fonts?', 'framework'),
                        'default' => '0',
                        'on' => __('Yes','framework'),
                        'off' => __('No','framework')
                    ),
                    array(
                        'id'        => 'headings_font',
                        'type'      => 'typography',
                        'title'     => __('Headings Font', 'framework'),
                        'subtitle'  => __('Select the font for headings.', 'framework'),
                        'desc'  => __('Lily Script One is default font.', 'framework'),
                        'required'  => array('want_to_change_fonts', '=', '1'),
                        'google'    => true,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'color'         => false,
                        'text-align'    => false,
                        'output'        => array( 'h1','h2','h3','h4','h5','h6', '.h1','.h2','.h3','.h4','.h5','.h6' ),
                        'default'       => array(
                            'font-family' => 'Lily Script One',
                            'google'      => true
                        )
                    ),
                    array(
                        'id'        => 'body_font',
                        'type'      => 'typography',
                        'title'     => __('Text Font', 'framework'),
                        'subtitle'  => __('Select the font for body text.', 'framework'),
                        'desc'  => __('Open Sans is default font.', 'framework'),
                        'required'  => array('want_to_change_fonts', '=', '1'),
                        'google'    => true,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'color'         => false,
                        'text-align'    => false,
                        'output'        => array( 'body' ),
                        'default'       => array(
                            'font-family' => 'Open Sans',
                            'google'      => true
                        )
                    ),
                    array(
                        'id'        => 'headings_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a'),
                        'title'     => __('Headings Color', 'framework'),
                        'desc'  => 'default: #3a4543',
                        'default'   => '#3a4543',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('body'),
                        'title'     => __('Text Color', 'framework'),
                        'desc'  => 'default: #7b7d85',
                        'default'   => '#7b7d85',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'quote_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('.format-quote .quote p', 'blockquote p' ),
                        'title'     => __('Quote Text Color', 'framework'),
                        'desc'  => 'default: #3a4543',
                        'default'   => '#3a4543',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'link_color_contents',
                        'type'      => 'link_color',
                        'title'     => __('Link Color in Contents', 'framework'),
                        'active'    => true,
                        'output'    => array( 'a' ),
                        'default'   => array(
                            'regular'   => '#66d9c1',
                            'hover'     => '#3a4543',
                            'active'     => '#3a4543'
                        )
                    ),
                    array(
                        'id'        => 'link_color_sidebar',
                        'type'      => 'link_color',
                        'title'     => __('Link Color in Sidebar', 'framework'),
                        'active'    => true,
                        'output'    => array( '.widget ul li a' ),
                        'default'   => array(
                            'regular'   => '#969d9b',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        )
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'default_btn_bg',
                        'type'      => 'link_color',
                        'title'     => __('Default Button Background Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#3a4543',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        )
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'default_btn_text_color',
                        'type'      => 'link_color',
                        'title'     => __('Default Button Text Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        )
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'light_btn_bg',
                        'type'      => 'link_color',
                        'title'     => __('Light Button Background Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#66d9c1',
                            'hover'     => '#3a4543',
                            'active'     => '#3a4543'
                        )
                    ),
                    // css generation code reside in css/dynamic-css.php
                    array(
                        'id'        => 'light_btn_text_color',
                        'type'      => 'link_color',
                        'title'     => __('Light Button Text Color', 'framework'),
                        'active'    => true,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        )
                    ),
                    array(
                        'id'        => 'quick_css',
                        'type'      => 'ace_editor',
                        'title'     => __('Quick CSS', 'framework'),
                        'desc'  => __('You can use this box for some quick css changes. For big changes, Use the custom.css file in css folder. In case of child theme please use style.css file in child theme.', 'framework'),
                        'mode'      => 'css',
                        'theme'     => 'monokai'
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Header Styling Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Header', 'framework'),
                'subsection' => true,
                'desc' => __('This section contains styling options for header', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'sticky_header',
                        'type' => 'switch',
                        'title' => __('Sticky Header?', 'framework'),
                        'subtitle' => __('Enable or Disable sticky header', 'framework'),
                        'default' => '0',
                        'on' => __('Enabled','framework'),
                        'off' => __('Disabled','framework')
                    ),
                    array(
                        'id'        => 'header_background',
                        'type'      => 'color',
                        'mode'      => 'background-color',
                        'output'    => array('.header-wrapper'),
                        'title'     => __('Header Background Color', 'framework'),
                        'desc'     => 'default: #2c2725',
                        'default'   => '#2c2725'
                    ),
                    array(
                        'id'        => 'header_bottom_border_color',
                        'type'      => 'color',
                        'mode'      => 'border-color',
                        'transparent' => false,
                        'output'    => array('.header-border-bottom'),
                        'title'     => __('Header Bottom Border Color', 'framework'),
                        'desc'  => 'default: #3f310a',
                        'default'   => '#3f310a',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'logo_color',
                        'type'      => 'link_color',
                        'title'     => __('Text Logo Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.logo a' ),
                        'default'   => array(
                            'regular'   => '#e5b65c',
                            'hover'     => '#66d9c1',
                            'active'     => '#66d9c1'
                        )
                    ),
                    array(
                        'id'        => 'header_tag_line_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('.logo small'),
                        'title'     => __('Tag Line Color', 'framework'),
                        'desc'  => 'default: #959185',
                        'default'   => '#959185',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'top_menu_items_color',
                        'type'      => 'link_color',
                        'title'     => __('Top Menu Items Text Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.main-menu > ul > li a' ),
                        'default'   => array(
                            'regular'   => '#9a928f',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        )
                    ),
                    array(
                        'id'        => 'header_sub_menu_background',
                        'type'      => 'color',
                        'mode'      => 'background-color',
                        'transparent' => false,
                        'output'    => array('.main-menu ul li > ul'),
                        'title'     => __('Sub Menu Background', 'framework'),
                        'desc'     => 'default: #2c2725',
                        'default'   => '#2c2725'
                    ),
                    array(
                        'id'        => 'sub_menu_bottom_border_color',
                        'type'      => 'color',
                        'mode'      => 'border-color',
                        'transparent' => false,
                        'output'    => array('.main-menu ul li > ul'),
                        'title'     => __('Sub Menu Bottom Border Color', 'framework'),
                        'desc'  => 'default: #e5b65c',
                        'default'   => '#e5b65c',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'sub_menu_items_color',
                        'type'      => 'link_color',
                        'title'     => __('Sub Menu Items Text Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.main-menu ul li > ul li a' ),
                        'default'   => array(
                            'regular'   => '#7f7977',
                            'hover'     => '#ffffff',
                            'active'     => '#ffffff'
                        )
                    ),
                    array(
                        'id'        => 'sub_menu_items_border_color',
                        'type'      => 'color',
                        'mode'      => 'border-color',
                        'transparent' => false,
                        'output'    => array('.main-menu ul li > ul li a'),
                        'title'     => __('Sub Menu Items Border Color', 'framework'),
                        'desc'  => 'default: #9b7c44',
                        'default'   => '#9b7c44',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'responsive_menu_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'background-color' => '.mean-container a.meanmenu-reveal span',
                            'color' => '.mean-container .mean-nav ul li a, .mean-container a.meanmenu-reveal',
                        ),
                        'title'     => __('Responsive Menu Text Color', 'framework'),
                        'desc'     => 'default: #ffffff',
                        'default'   => '#ffffff'
                    ),
                    array(
                        'id'        => 'responsive_menu_hover_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.mean-container .mean-nav ul li a:hover',
                        ),
                        'title'     => __('Responsive Menu Hover Color', 'framework'),
                        'desc'     => 'default: #e5b65c',
                        'default'   => '#e5b65c'
                    ),
                    array(
                        'id'        => 'responsive_menu_border_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'border-color' => '.mean-container .mean-nav ul li a, .mean-container .mean-nav ul li li a',
                        ),
                        'title'     => __('Responsive Menu Border Color', 'framework'),
                        'desc'     => 'default: #9b7c44',
                        'default'   => '#9b7c44'
                    ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Header Styling Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Twitter', 'framework'),
                'subsection' => true,
                'desc' => __('This section contains styling options for twitter section above footer.', 'framework'),
                'fields' => array(
                    array(
                        'id'        => 'twitter_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.twitter-feeds'
                        ),
                        'title'     => __('Twitter Section Background Color', 'framework'),
                        'desc'     => 'default: #fbd27a',
                        'default'   => '#fbd27a'
                    ),
                    array(
                        'id'        => 'twitter_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array(
                            'color' => '.twitter-feeds .inline_tweet'
                        ),
                        'title'     => __('Tweet Text Color', 'framework'),
                        'desc'     => 'default: #3a4543',
                        'default'   => '#3a4543'
                    ),
                    array(
                        'id'        => 'twitter_link_color',
                        'type'      => 'link_color',
                        'title'     => __('Tweet Link Color', 'framework'),
                        'active'    => true,
                        'output'    => array( '.twitter-feeds a' ),
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#3a4543',
                            'active'     => '#ffffff'
                        )
                    ),
                    array(
                        'id'        => 'twitter_sparrow_color',
                        'type'      => 'link_color',
                        'title'     => __('Twitter Sparrow Color', 'framework'),
                        'active'    => false,
                        'output'    => array( '.twitter-feeds .twitter-icon i' ),
                        'default'   => array(
                            'regular'   => '#3a4543',
                            'hover'     => '#f1c76e'
                        )
                    ),
                    array(
                        'id'        => 'twitter_sparrow_bg_color',
                        'type'      => 'link_color',
                        'title'     => __('Twitter Sparrow Background Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#f1c76e',
                            'hover'     => '#ffffff'
                        )
                    ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Footer Styling Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Footer', 'framework'),
                'subsection' => true,
                'desc' => __('This section contains styling options for footer', 'framework'),
                'fields' => array(
                    array(
                        'id'        => 'footer_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => 'footer.footer'
                        ),
                        'title'     => __('Footer Background Color', 'framework'),
                        'desc'     => 'default: #282424',
                        'default'   => '#282424',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'footer_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array( 'footer.footer' ),
                        'title'     => __('Footer Text Color', 'framework'),
                        'desc'  => 'default: #6e6d6d',
                        'default'   => '#6e6d6d',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'footer_link_color',
                        'type'      => 'link_color',
                        'title'     => __('Footer Link Color', 'framework'),
                        'output'    => array( '.footer a' ),
                        'default'   => array(
                            'regular'   => '#6e6d6d',
                            'hover'     => '#ffffff',
                            'active'    => '#fbd27a'
                        )
                    ),
                    array(
                        'id'        => 'footer_border_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'title'     => __('Borders Color in Footer', 'framework'),
                        'output'    => array(
                            'border-color' =>'.footer .footer-menu-wrapper, .footer .invitation'
                        ),
                        'desc'  => 'default: #3a3a3a',
                        'default'   => '#3a3a3a',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'footer_social_icons_color',
                        'type'      => 'link_color',
                        'title'     => __('Footer Social Icons Color', 'framework'),
                        'output'    => array('.social_networks li a'),
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#66d9c1',
                            'active'     => '#fbd27a'
                        )
                    ),
                    array(
                        'id'        => 'footer_bottom_background',
                        'type'      => 'color',
                        'output'    => array(
                            'background-color' => '.footer-bottom'
                        ),
                        'title'     => __('Footer Bottom Area Background Color', 'framework'),
                        'desc'     => 'default: #181515',
                        'default'   => '#181515',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'footer_copyright_text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('.footer-bottom p'),
                        'title'     => __('Footer Copyright Text Color', 'framework'),
                        'desc'  => 'default: #6e6d6d',
                        'default'   => '#6e6d6d',
                        'validate'  => 'color'
                    ),
                    array(
                        'id'        => 'footer_scroll_top_bg',
                        'type'      => 'link_color',
                        'title'     => __('Scroll Top Arrow Background Color', 'framework'),
                        'default'   => array(
                            'regular'   => '#3a3a3a',
                            'hover'     => '#212121',
                            'active'     => '#212121'
                        )
                    )
                )
            );


            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'framework'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'framework'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'framework'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'framework');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array (
                'opt_name' => 'redux_demo',
                'global_variable' => 'theme_options',
                'admin_bar' => '1',
                'allow_sub_menu' => '1',
                'default_mark' => '*',
                'google_api_key' => 'AIzaSyDGNqc0QLD7SceugylqYVWcik-hGVxlnAs',
                'hint-icon' => 'el-icon-question-sign',
                'icon_position' => 'right',
                'icon_size' => 'normal',
                'tip_style_color' => 'light',
                'tip_position_my' => 'top left',
                'tip_position_at' => 'bottom right',
                'tip_show_duration' => '500',
                'tip_show_event' => 
                array (
                  0 => 'mouseover',
                ),
                'tip_hide_duration' => '500',
                'tip_hide_event' => 
                array (
                  0 => 'mouseleave',
                  1 => 'unfocus',
                ),
                'menu_title' => 'Theme Options',
                'menu_type' => 'menu',
                'output' => '1',
                'output_tag' => '1',
                'page_icon' => 'icon-themes',
                'page_parent_post_type' => 'your_post_type',
                'page_permissions' => 'manage_options',
                'page_slug' => 'cream_options',
                'page_title' => 'Theme Options',
                'save_defaults' => '1',
                'show_import_export' => '1',
            );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Cream_Theme_Redux_Framework_Config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_demo_my_custom_field')):
    function redux_demo_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_demo_validate_callback_function')):
    function redux_demo_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
