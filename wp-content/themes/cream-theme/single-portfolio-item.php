<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content container">
    <div class="row">
        <div class="main col-xs-12" role="main">
            <div class="showcase clearfix">
                <!--<div class="control-nav">
                    <?php /* previous_post_link('%link', ''); */?>
                    <?php /* next_post_link('%link', ''); */?>
                </div>-->
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                    the_post();
                    ?>
                    <article class="clearfix">
                        <!--<h1 class="entry-title"><?php /*the_title(); */?></h1>-->
                        <?php inspiry_portfolio_item_header(); ?>
                        <div class="entry-content clearfix">
                            <?php
                            /* output contents */
                            the_content();
                            ?>
                            <hr/>
                        </div>
                    </article>
                    <?php
                    endwhile;
                endif;
                ?>
            </div>

            <?php
            if( true ){
                global $post;

                $related_items_args = array(
                    'post_type' => 'portfolio-item',
                    'posts_per_page' => 3,
                    'post__not_in' => array($post->ID),
                    'orderby' => 'rand'
                );

                /* Main gallery-item-types terms */
                $tax_query = array();
                $item_type_terms = get_the_terms($post->ID, "portfolio-item-type");
                if (!empty($item_type_terms) && is_array($item_type_terms)) {
                    $gallery_item_types_array = array();
                    foreach ($item_type_terms as $single_term) {
                        $gallery_item_types_array[] = $single_term->term_id;
                    }
                    $tax_query[] = array(
                        'taxonomy' => 'portfolio-item-type',
                        'field' => 'id',
                        'terms' => $gallery_item_types_array
                    );
                }

                $tax_count = count($tax_query); // count number of taxonomies
                if ($tax_count > 0) {
                    $related_items_args['tax_query'] = $tax_query; // add taxonomies query
                }

                // Related items query
                $related_items_query = new WP_Query($related_items_args);

                if ($related_items_query->have_posts()) {
                    $loop_counter = 0;
                    ?>
                    <div id="gallery-container" class="related-projects">
                        <h3 class="title"><?php _e('Related Items', 'framework'); ?></h3>
                        <div class="row">
                            <?php
                            while ($related_items_query->have_posts()) {
                                $related_items_query->the_post();
                                if (has_post_thumbnail($post->ID)) {
                                    $image_id = get_post_thumbnail_id();
                                    $full_image_url = wp_get_attachment_url($image_id);
                                    ?>
                                    <div class="gallery-item col-xs-4">
                                        <article>
                                            <div class="overlay">
                                                <div class="content">
                                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    <div class="wrapper">
                                                        <div class="middle-line"></div>
                                                        <a data-imagelightbox="lightbox" class="zoom" href="<?php echo $full_image_url; ?>"><i class="fa fa-search"></i></a>
                                                        <a class="link" href="<?php the_permalink(); ?>" title=""><i class="fa fa-link"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php the_post_thumbnail( 'portfolio-thumb', array( 'class' => 'img-responsive' ) ); ?>
                                        </article>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div><!-- end of .row -->
</div><!-- end of page content -->

<?php
/* Include Footer */
get_footer();
?>