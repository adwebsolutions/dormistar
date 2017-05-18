<?php
/*-----------------------------------------------------------------------------------*/
/*	Create the Portfolio Item Custom Post Type
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_portfolio_post_type')) {
    function create_portfolio_post_type(){
        $labels = array(
            'name' => __( 'Portfolio','framework'),
            'singular_name' => __( 'Portfolio Item','framework' ),
            'add_new' => __('Add New','framework'),
            'add_new_item' => __('Add New Portfolio Item','framework'),
            'edit_item' => __('Edit Portfolio Item','framework'),
            'new_item' => __('New Portfolio Item','framework'),
            'view_item' => __('View Portfolio Item','framework'),
            'search_items' => __('Search Portfolio Items','framework'),
            'not_found' =>  __('No Portfolio Item found','framework'),
            'not_found_in_trash' => __('No Portfolio Item found in Trash','framework'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array('title','editor','thumbnail'),
            'rewrite' => array( 'slug' => __('portfolio-item', 'framework') )
        );
        register_post_type('portfolio-item', $args);
    }
}
add_action('init', 'create_portfolio_post_type');


/*-----------------------------------------------------------------------------------*/
/*	Create Portfolio Item Type Taxonomy
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_portfolio_item_type_taxonomy')) {
    function create_portfolio_item_type_taxonomy()
    {
        $labels = array(
            'name' => __( 'Portfolio Item Types', 'framework' ),
            'singular_name' => __( 'Portfolio Item Type', 'framework' ),
            'search_items' =>  __( 'Search Portfolio Item Types', 'framework' ),
            'popular_items' => __( 'Popular Portfolio Item Types', 'framework' ),
            'all_items' => __( 'All Portfolio Item Types', 'framework' ),
            'parent_item' => __( 'Parent Portfolio Item Type', 'framework' ),
            'parent_item_colon' => __( 'Parent Portfolio Item Type:', 'framework' ),
            'edit_item' => __( 'Edit Portfolio Item Type', 'framework' ),
            'update_item' => __( 'Update Portfolio Item Type', 'framework' ),
            'add_new_item' => __( 'Add New Portfolio Item Type', 'framework' ),
            'new_item_name' => __( 'New Portfolio Item Type Name', 'framework' ),
            'separate_items_with_commas' => __( 'Separate Portfolio Item Types with commas', 'framework' ),
            'add_or_remove_items' => __( 'Add or Remove Portfolio Item Types', 'framework' ),
            'choose_from_most_used' => __( 'Choose from the most used Portfolio Item Types', 'framework' ),
            'menu_name' => __( 'Types', 'framework' )
        );

        register_taxonomy(
            'portfolio-item-type',
            array( 'portfolio-item' ),
            array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => __('portfolio-item-type', 'framework') )
            )
        );
    }
}
add_action('init', 'create_portfolio_item_type_taxonomy', 0);


/*-----------------------------------------------------------------------------------*/
/*	Add Custom Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('portfolio_edit_columns')) {
    function portfolio_edit_columns($columns) {
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __('Portfolio Item Title', 'framework'),
            "portfolio-thumb" => __('Thumbnail', 'framework'),
            "type" => __('Type', 'framework'),
            "date" => __('Publish Time', 'framework')
        );
        return $columns;
    }
}
add_filter("manage_edit-portfolio-item_columns", "portfolio_edit_columns");


/*-----------------------------------------------------------------------------------*/
/*	Output Custom Columns Contents
/*-----------------------------------------------------------------------------------*/
if (!function_exists('portfolio_custom_columns')) {
    function portfolio_custom_columns($column)
    {
        global $post;
        switch ($column) {
            case 'portfolio-thumb':
                if (has_post_thumbnail($post->ID)) {
                    ?>
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </a>
                <?php
                } else {
                    _e('No Thumbnail', 'framework');
                }
                break;

            case 'type':
                echo get_the_term_list($post->ID, 'portfolio-item-type', '', ', ', '');
                break;
        }
    }
}
add_action("manage_posts_custom_column", "portfolio_custom_columns");
?>