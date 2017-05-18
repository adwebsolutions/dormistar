<?php
/* common excerpt template for search results */
global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?> >
    <?php inspiry_standard_thumbnail(); ?>
    <header class="entry-header">
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    </header>
    <div class="entry-content">
        <?php the_excerpt(); ?>
    </div>
    <a class="theme-btn" href="<?php the_permalink(); ?>" rel="bookmark"><?php _e('Read More', 'framework'); ?></a>
</article>