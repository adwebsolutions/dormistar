<?php
global $post;
$format = get_post_format($post->ID);
if (false === $format) {
    $format = 'standard';
}
?>
<!-- Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>

    <?php
    /* Get post header based on format */
    get_template_part("post-formats/$format");

    if (($format !== 'quote') && ($format !== 'link')) {
        ?>
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
            </div>
        </header>
        <div class="entry-content">
            <?php the_content(''); ?>
        </div>
        <a class="theme-btn" href="<?php the_permalink(); ?>" rel="bookmark"><?php _e('Read More', 'framework'); ?></a>
        <?php
    }
    ?>
</article>