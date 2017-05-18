<?php
global $post;
$format = get_post_format($post->ID);
if (false === $format) {
    $format = 'standard';
}
?>
<div class="item col-xs-6 col-sm-6 col-md-4 col-lg-4">

    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>

        <?php
        /* Get post header based on format */
        get_template_part("post-formats/$format");

        if (($format !== 'quote') && ($format !== 'link')) {
            ?>
            <div class="wrapper">

                <header class="entry-header">
                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    <div class="entry-meta post-meta">
                        <span class="byline">
                            <span class="author vcard"><?php _e('By', 'framework'); ?> <?php the_author_posts_link(); ?></span>
                        </span>
                        <span class="entry-date date">
                            <?php _e('on', 'framework'); ?> <time class="entry-date" datetime="<?php the_time('c'); ?>"><?php the_time('M d, Y'); ?></time>
                        </span>
                    </div>
                </header>

                <div class="entry-summary entry-content">
                    <p><?php  inspiry_excerpt(16); ?></p>
                </div>

                <footer class="entry-meta-footer">
                    <?php comments_popup_link('<i class="fa fa-comments"></i>'.__('0', 'framework'), '<i class="fa fa-comments"></i>'.__('1', 'framework'), '<i class="fa fa-comments"></i>'.__('%', 'framework'), 'comments'); ?>
                </footer>

            </div>
            <?php
        }
        ?>

    </article>

</div>
