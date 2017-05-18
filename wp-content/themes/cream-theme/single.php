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
                    $format = get_post_format($post->ID);
                    if (false === $format) {
                        $format = 'standard';
                    }
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?> >

                        <?php
                        /* Get post header based on format */
                        get_template_part("post-formats/$format");

                        if (($format !== 'quote') && ($format !== 'link')) {
                            ?>
                            <header class="entry-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-meta post-meta">
                                    <span class="entry-updated">
                                        <i class="fa fa-calendar"></i><time class="updated" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_time('M d, Y'); ?></time>
                                    </span>
                                    <span class="entry-author vcard">
                                        <i class="fa fa-user"></i>
                                        <?php
                                        printf( '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
                                            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                                            esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
                                            get_the_author()
                                        );
                                        ?>
                                    </span>
                                    <span class="entry-comments-link">
                                        <i class="fa fa-comments"></i><?php comments_popup_link(__('0', 'framework'), __('1', 'framework'), __('%', 'framework')); ?>
                                    </span>
                                    <span class="entry-categories">
                                        <i class="fa fa-folder-open"></i><?php the_category(', '); ?>
                                    </span>
                                </div>
                            </header>
                            <?php
                        }
                        ?>

                        <div class="entry-content post-content-wrapper clearfix">
                            <?php
                            /* output post contents */
                            the_content();

                            // WordPress Link Pages
                            wp_link_pages(array('before' => '<div class="page-nav-btns clearfix">', 'after' => '</div>', 'next_or_number' => 'next'));
                            ?>
                        </div>

                        <?php
                        if ( get_the_terms( $post->ID, 'post_tag' ) ){
                            ?>
                            <footer class="entry-footer">
                                <p class="entry-meta">
                                    <span class="entry-tags">
                                        <i class="fa fa-tags"></i>&nbsp; <?php the_tags('', ', ', ''); ?>
                                    </span>
                                </p>
                            </footer>
                            <?php
                        }
                        ?>

                    </article>
                    <?php
                endwhile;
            endif;


            if( get_the_author_meta('description') != '' )
            {
                ?>
                <section class="post-author clearfix vcard">
                    <div class="gravatar">
                        <?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100' ); } ?>
                    </div>
                    <div class="details">
                        <h4><?php the_author_posts_link(); ?>&nbsp;<span>Author</span></h4>
                        <p><?php the_author_meta('description'); ?></p>
                        <?php
                        // Get user social profile urls
                        $facebook_profile = get_the_author_meta( 'facebook_profile' );
                        $twitter_profile = get_the_author_meta( 'twitter_profile' );
                        $linkedin_profile = get_the_author_meta( 'linkedin_profile' );
                        $google_profile = get_the_author_meta( 'google_profile' );
                        $rss_url = get_the_author_meta( 'rss_url' );

                        if( !empty( $facebook_profile ) || !empty( $twitter_profile ) || !empty( $linkedin_profile ) || !empty( $google_profile ) || !empty( $rss_url ) ){
                            ?>
                            <div class="social-profiles">
                                <ul class="social_networks clearfix">
                                    <?php
                                    if( !empty( $facebook_profile ) ){
                                        ?>
                                        <li class="facebook">
                                            <a href="<?php echo $facebook_profile; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <?php
                                    }

                                    if( !empty( $twitter_profile ) ){
                                        ?>
                                        <li class="twitter">
                                            <a href="<?php echo $twitter_profile; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <?php
                                    }

                                    if( !empty( $linkedin_profile ) ){
                                        ?>
                                        <li class="linkedin">
                                            <a href="<?php echo $linkedin_profile; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                        <?php
                                    }

                                    if( !empty( $google_profile ) ){
                                        ?>
                                        <li class="gplus">
                                            <a href="<?php echo $google_profile; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <?php
                                    }

                                    if( !empty( $rss_url ) ){
                                        ?>
                                        <li class="rss">
                                            <a target="_blank" href="<?php echo $rss_url; ?>"><i class="fa fa-rss"></i></a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>
                <?php
            }

            /* comments */
            comments_template();

            ?>
        </div>

        <?php get_sidebar(); ?>

    </div>

</div><!-- end of page content -->


<?php get_footer(); ?>
