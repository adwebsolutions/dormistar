<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content portfolio-content container">
    <div class="row">
        <div class="main col-xs-12" role="main">
            <?php
            /* Data Contents */
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    $content = get_the_content();
                    if (!empty($content)) {
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>
                            <div class="entry-content post-content-wrapper clearfix">
                                <?php
                                /* output post contents */
                                the_content();
                                ?>
                            </div>
                        </article>
                        <?php
                    }
                endwhile;
            endif;
            ?>

            <!-- Filter -->
            <div id="filter-by" class="gallery-item-filter">
                <ul class="clearfix">
                    <li><a href="#" data-filter="gallery-item" class="active"><?php _e('All', 'framework'); ?></a></li>
                    <?php
                    global $post;
                    $args = array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => true,
                    );
                    $tax_terms = get_terms('portfolio-item-type', $args);
                    if (!empty($tax_terms)) {
                        foreach ($tax_terms as $term) {
                            echo '<li><a href="#" data-filter="' . $term->slug . '">' . $term->name . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Portfolio Items -->
            <div id="gallery-container">
                <div class="row isotope">
                    <?php
                    $args = array(
                        'post_type' => 'portfolio-item',
                        'posts_per_page' => -1,
                    );

                    // The Query
                    $gallery_query = new WP_Query($args);

                    // The Loop
                    if ($gallery_query->have_posts()) {

                        /* decide appropriate bootstrap classes */
                        $bootstrap_classes = array(
                            'gallery-2-column' => 'col-xs-6',
                            'gallery-3-column' => 'col-md-4 col-xs-6',
                            'gallery-4-column' => 'col-lg-3 col-md-4 col-xs-6'
                        );

                        // 4 columns portfolio
                        if ( is_page_template('portfolio/four-col-template.php') ) {

                            $classes = $bootstrap_classes['gallery-4-column'];

                        // 3 columns portfolio
                        } else if ( is_page_template('portfolio/three-col-template.php') ) {

                            $classes = $bootstrap_classes['gallery-3-column'];

                        // 2 columns portfolio
                        } else if ( is_page_template('portfolio/two-col-template.php') ) {

                            $classes = $bootstrap_classes['gallery-2-column'];

                        }else{
                            // default = 3 columns portfolio
                            $classes = $bootstrap_classes['gallery-3-column'];

                        }

                        while ($gallery_query->have_posts()) {
                            $gallery_query->the_post();

                            /* department terms slug needed to be used as classes in html for isotope functionality */
                            $gallery_item_terms = get_the_terms($post->ID, 'portfolio-item-type');
                            $gallery_terms_slugs = '';
                            if (!empty($gallery_item_terms)) {
                                foreach ($gallery_item_terms as $term) {
                                    if (!empty($gallery_terms_slugs))
                                        $gallery_terms_slugs .= ' ';

                                    $gallery_terms_slugs .= $term->slug;
                                }
                            }

                            if (has_post_thumbnail($post->ID)) {
                                $image_id = get_post_thumbnail_id();
                                $full_image_url = wp_get_attachment_url($image_id);
                                ?>
                                <div class="gallery-item isotope-item <?php echo $gallery_terms_slugs; ?> <?php echo $classes; ?>">
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
                    } else {
                        nothing_found(__('No portfolio item found!', 'framework'));
                    }

                    /* Restore original Post Data */
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- end of page content -->


<?php get_footer(); ?>
