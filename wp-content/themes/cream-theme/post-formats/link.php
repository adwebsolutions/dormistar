<?php
/* for link post format */
global $post;

/* Display Featured Image if Any */
inspiry_standard_thumbnail();

$link_text = get_post_meta( $post->ID, 'inspiry_meta_link_text', true ); // link text
$link_url = get_post_meta( $post->ID, 'inspiry_meta_link_url', true ); // link URL

if( is_page_template( 'homepage-template.php' )
    || is_page_template( 'homepage-template-slider-rev.php' )
    || is_page_template( 'homepage-template-var-2.php' )
    || is_page_template( 'homepage-template-var-3.php' ) ){
    echo '<div class="wrapper">';
}

?>
<div class="link clearfix">
    <div class="link-container">
        <?php
        if (!empty($link_text)) {
            ?><h2 class="entry-title"><?php echo $link_text; ?></h2><?php
        } else {
            ?><h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2><?php
        }

        if ( !empty($link_url) ) {
            ?><a class="link-anchor" href="<?php echo $link_url ?>" target="_blank"><?php echo $link_url ?></a><?php
        } else if( !is_single() ){
            the_content('');
        }
        ?>
    </div>
    <div class="entry-meta hidden">
        <time class="updated" datetime="<?php the_modified_time('c'); ?>"><?php the_modified_time('M d, Y'); ?></time>
        <span class="entry-author vcard">
            <?php
            printf( '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
                get_the_author()
            );
            ?>
        </span>
    </div>
</div>
<?php
if( is_page_template( 'homepage-template.php' )
    || is_page_template( 'homepage-template-slider-rev.php' )
    || is_page_template( 'homepage-template-var-2.php' )
    || is_page_template( 'homepage-template-var-3.php' ) ){
    echo '</div>';
}
?>