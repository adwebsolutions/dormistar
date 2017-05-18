<section class="home-work-section clearfix">

    <?php
    global $theme_options;
    if ((!empty($theme_options['home_portfolio_title'])) || (!empty($theme_options['home_portfolio_description']))) {
        ?>
        <div class="container">
            <header class="section-header">
                <?php
                if (!empty($theme_options['home_portfolio_title'])) {
                    echo '<h2 class="section-title fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_portfolio_title'] . '</h2>';
                }
                if (!empty($theme_options['home_portfolio_description'])) {
                    echo '<p class="fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_portfolio_description'] . '</p>';
                }
                ?>
            </header>
        </div>
        <?php
    }
    ?>


    <div class="carousel-wrapper">
        <div class="work-items-carousel fade-in-up <?php echo inspiry_animation_class(); ?>">
            <?php
            // number of portfolio items
            $number_of_items = -1;
            if( !empty( $theme_options['home_portfolio_number_of_items'] ) ){
                $number_of_items = intval( $theme_options['home_portfolio_number_of_items'] );
            }

            // order by
            $order_by = 'date';
            if( !empty( $theme_options['home_portfolio_order_by'] ) ){
                $order_by = $theme_options['home_portfolio_order_by'];
            }

            // order
            $order = 'DESC';
            if( !empty( $theme_options['home_portfolio_order'] ) ){
                $order = $theme_options['home_portfolio_order'];
            }

            $portfolio_query_args = array(
                'post_type' => 'portfolio-item',
                'posts_per_page' => $number_of_items,
                'orderby' => $order_by,
                'order' => $order
            );

            // The Query
            $portfolio_query = new WP_Query( $portfolio_query_args );

            if ($portfolio_query->have_posts()) {

                // number of rows in home portfolio
                if( !empty( $theme_options['home_portfolio_rows'] ) ){
                    $required_number_of_rows = intval( $theme_options['home_portfolio_rows'] );
                }else{
                    $required_number_of_rows = 1;
                }

                $item_counter = 0;              // item counter to implement the number of rows logic
                while ( $portfolio_query->have_posts() ) {
                    $portfolio_query->the_post();

                    if ( has_post_thumbnail( $post->ID ) ) {

                        if( ($item_counter % $required_number_of_rows) == 0 ){
                            echo '<div class="work-snippet">';
                        }

                        $image_id = get_post_thumbnail_id();    // thumbnail id
                        $full_image_url = wp_get_attachment_url( $image_id );   // thumbnail full image
                        $image_src = wp_get_attachment_image_src( $image_id, 'portfolio-thumb' );   // thumbnail portfolio thumb size image source
                        ?>
                        <article class="clearfix">
                            <?php echo '<img src="'.$image_src[0].'" alt="'.get_the_title($post->ID).'"/>'; ?>
                            <div class="overly">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php inspiry_excerpt(9); ?></p>
                                <a class="preview-icon" data-imagelightbox="lightbox" href="<?php echo $full_image_url; ?>"><i class="fa fa-search"></i></a>
                                <a class="link-icon" href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
                            </div>
                        </article>
                        <?php

                        $item_counter++;
                        if( ($item_counter % $required_number_of_rows) == 0 ){
                            echo '</div>';
                        }
                    }
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>

</section>
