<section class="home-blog-section clearfix">

    <div class="container">

        <?php
        global $theme_options;
        if ( !empty( $theme_options['home_news_title'] ) || !empty( $theme_options['home_news_description'] ) ) {
            ?>
            <header class="section-header">
                <?php
                if (!empty( $theme_options['home_news_title'] ) ) {
                    echo '<h2 class="section-title">' . $theme_options['home_news_title'] . '</h2>';
                }
                if ( !empty( $theme_options['home_news_description'] ) ) {
                    echo '<p>' . $theme_options['home_news_description'] . '</p>';
                }
                ?>
            </header>
            <?php
        }

        // number of portfolio items
        $number_of_items = 6;
        if( !empty( $theme_options['home_number_of_news_items'] ) ){
            $number_of_items = intval( $theme_options['home_number_of_news_items'] );
        }

        // order by
        $order_by = 'date';
        if( !empty( $theme_options['home_news_order_by'] ) ){
            $order_by = $theme_options['home_news_order_by'];
        }

        // order
        $order = 'DESC';
        if( !empty( $theme_options['home_news_order'] ) ){
            $order = $theme_options['home_news_order'];
        }

        $blog_posts_args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_of_items,
            'orderby' => $order_by,
            'order' => $order,
            'ignore_sticky_posts' => 1
        );

        // The Query
        $blog_query = new WP_Query( $blog_posts_args );

        // The Loop
        if ( $blog_query->have_posts() ) {
            ?>
            <div id="blog-posts-container">

                <div class="row blog-items">

                    <?php
                    while ($blog_query->have_posts()) {
                        $blog_query->the_post();
                        global $post;
                        $format = get_post_format($post->ID);
                        if (false === $format) {
                            $format = 'standard';
                        }
                        get_template_part('template-parts/home-blog-post');
                    }
                    ?>
                </div>

            </div>
            <?php
        }

        wp_reset_postdata();
        ?>

    </div>

</section>