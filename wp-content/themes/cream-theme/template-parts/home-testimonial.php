<section class="home-testimonial-section">
    <?php
    global $theme_options;

    if ( ( !empty( $theme_options['home_testimonials_title'] ) ) || ( !empty( $theme_options['home_testimonials_description'] ) ) ) {
        ?>
        <div class="container">
            <header class="section-header">
                <?php
                if ( !empty( $theme_options['home_testimonials_title'] ) ) {
                    echo '<h2 class="section-title fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_testimonials_title'] . '</h2>';
                }
                if ( !empty( $theme_options['home_testimonials_description'] ) ) {
                    echo '<p class="fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_testimonials_description'] . '</p>';
                }
                ?>
            </header>
        </div>
        <?php
    }


    // number of testimonials
    $number_of_items = -1;
    if( !empty( $theme_options['home_number_of_testimonials'] ) ){
        $number_of_items = intval( $theme_options['home_number_of_testimonials'] );
    }

    // order by
    $order_by = 'date';
    if( !empty( $theme_options['home_testimonial_order_by'] ) ){
        $order_by = $theme_options['home_testimonial_order_by'];
    }

    $testimonial_args = array(
        'post_type' => 'testimonial',
        'posts_per_page' => $number_of_items,
        'orderby' => $order_by
    );

    // The Query
    $testimonial_query = new WP_Query($testimonial_args);

    // The Loop
    if ($testimonial_query->have_posts()) {
        ?>
        <div class="testimonial-carousel">
            <div class="container">
                <div class="carousel fade-in-right <?php echo inspiry_animation_class(); ?>">
                <?php
                while ($testimonial_query->have_posts()) {
                    $testimonial_query->the_post();
                    $testimonial_text = get_post_meta( $post->ID,'the_testimonial',true );
                    ?>
                    <div class="testimonial-content clearfix">
                        <?php
                        if ( has_post_thumbnail() ) {
                            ?>
                            <div class="testimonial-author-photo">
                                <div class="vertical-line"></div>
                                <div class="img-frame">
                                    <span><?php the_post_thumbnail( 'thumbnail', array( 'class' => "img-circle" ) ); ?></span>
                                </div>
                            </div>
                            <?php
                        }

                        if( !empty($testimonial_text) ){
                            $testimonial_author_link = get_post_meta( $post->ID, 'testimonial_author_link', true );
                            $testimonial_author = get_post_meta( $post->ID,'testimonial_author',true );
                            ?>
                            <blockquote class="testimonial-text">
                                <p><?php echo $testimonial_text; ?></p>
                                <?php
                                if( !empty( $testimonial_author ) ){
                                    if ( !empty( $testimonial_author_link ) ) {
                                        ?>
                                        <a class="testimonial-author  fn" target="_blank" href="<?php echo $testimonial_author_link; ?>">
                                            <cite><?php echo $testimonial_author; ?></cite>
                                        </a>
                                        <?php
                                    }else{
                                        ?><cite><?php echo $testimonial_author; ?></cite><?php
                                    }
                                }
                                ?>
                            </blockquote>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            <div class="testimonial-carousel-nav">
                <a class="carousel-prev-item prev"></a>
                <a class="carousel-next-item next"></a>
            </div>
        </div>
        <?php
    }

    /* Restore original Post Data */
    wp_reset_postdata();
    ?>
</section>
