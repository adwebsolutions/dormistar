<?php
/*
*   Template Name: Full Width Template
*/

/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content container">

    <div class="row">

        <div class="main col-xs-12" role="main">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(' clearfix'); ?>>
                        <div class="full-width-contents">
                            <header class="entry-header">
                                <?php
                                /* Page Featured Image */
                                inspiry_standard_thumbnail('default-page');

                                $page_title_display = get_post_meta( $post->ID, 'inspiry_meta_page_title_display', true );
                                if( $page_title_display != 'hide' ){
                                    ?><h1 class="entry-title"><?php the_title(); ?></h1><?php
                                }
                                ?>
                                <time class="updated hidden" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_time('M d, Y'); ?></time>
                            </header>
                            <div class="entry-content">
                                <?php
                                /* output page contents */
                                the_content();

                                // WordPress Link Pages
                                wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                                ?>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
            endif;

            // comments template
            comments_template();
            ?>
        </div>

    </div>
</div><!-- end of page content -->


<?php get_footer(); ?>
