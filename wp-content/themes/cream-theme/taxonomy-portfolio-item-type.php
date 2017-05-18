<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/taxonomy-banner');
?>

<!-- start of page content -->
<div class="page-content portfolio-content container">

    <div class="row">

        <div class="main col-xs-12" role="main">

            <!-- Portfolio Items -->
            <div id="gallery-container">

                <div class="row isotope">
                    <?php
                    // The Loop
                    if ( have_posts() ) {

                        while ( have_posts() ) {

                            the_post();

                            if ( has_post_thumbnail( $post->ID ) ) {
                                $image_id = get_post_thumbnail_id();
                                $full_image_url = wp_get_attachment_url( $image_id );
                                ?>
                                <div class="gallery-item isotope-item col-md-4 col-xs-6">
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
                    ?>
                </div>

            </div>

        </div>

    </div>

</div>
<!-- end of page content -->

<?php get_footer(); ?>