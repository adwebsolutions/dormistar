<?php
/* For quote post format */
global $post;

/* Display Featured Image if Any */
inspiry_standard_thumbnail();


$quote_author = get_post_meta($post->ID, 'inspiry_meta_quote_author', true); // quote author
$quote_desc = get_post_meta($post->ID, 'inspiry_meta_quote_desc', true); // quote text

if( is_page_template( 'homepage-template.php' )
    || is_page_template( 'homepage-template-slider-rev.php' )
    || is_page_template( 'homepage-template-var-2.php' )
    || is_page_template( 'homepage-template-var-3.php' )){
    echo '<div class="wrapper">';
}

if ( !empty($quote_desc) ) {
    ?>
    <div class="entry-content">
        <blockquote class="quote">
            <p>
                <?php
                echo $quote_desc;
                if (!empty($quote_author)) {
                    ?><cite><?php echo $quote_author ?></cite><?php
                }
                ?>
            </p>
        </blockquote>
    </div>
    <div class="entry-meta post-meta">
        <span class="entry-updated">
            <i class="fa fa-calendar"></i><time class="updated" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_time('M d, Y'); ?></time>
        </span>
        <a class="entry-title hidden" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        <span class="entry-author vcard hidden">
            <?php
            printf( '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
                get_the_author()
            );
            ?>
        </span>
    </div>
    <?php
} else if( !is_single() ){
    ?>
    <div class="entry-content">
        <?php the_content(''); ?>
    </div>
    <?php
}

if( is_page_template( 'homepage-template.php' )
    || is_page_template( 'homepage-template-slider-rev.php' )
    || is_page_template( 'homepage-template-var-2.php' )
    || is_page_template( 'homepage-template-var-3.php' ) ){
    echo '</div>';
}
?>