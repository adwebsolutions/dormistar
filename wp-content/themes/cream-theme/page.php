<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content container">

    <div class="row">

        <div class="main col-md-8 col-lg-8" role="main">

            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();

                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>

                        <?php
                        if ( has_post_thumbnail($post->ID) ) {
                            $image_id = get_post_thumbnail_id();
                            $full_image_url = wp_get_attachment_url($image_id);
                            ?>
                            <figure>
                                <a data-imagelightbox="lightbox" href="<?php echo $full_image_url; ?>" title="<?php the_title(); ?>">
                                    <?php the_post_thumbnail( 'blog-page', array('class'=>"img-responsive") ); ?>
                                </a>
                            </figure>
                            <?php
                        }
                        ?>
                        <header class="entry-header">
                            <?php
                            $page_title_display = get_post_meta( $post->ID, 'inspiry_meta_page_title_display', true );
                            if( $page_title_display != 'hide' ){
                                ?><h1 class="entry-title"><?php the_title(); ?></h1><?php
                            }
                            ?>
                            <time class="updated hidden" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_time('M d, Y'); ?></time>
                        </header>


                        <div class="entry-content post-content-wrapper clearfix">
                            <?php
                            /* output post contents */
                            the_content();

                            // WordPress Link Pages
                            wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                            ?>
                        </div>

                    </article>
                <?php
                endwhile;
            endif;

            /* comments */
            comments_template();

            ?>
        </div>

        <?php get_sidebar('page'); ?>

    </div>

</div><!-- end of page content -->


<?php get_footer(); ?>
