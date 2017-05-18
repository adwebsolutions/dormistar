<?php
// Banner Title
$banner_title_display = get_post_meta( $post->ID, 'inspiry_meta_banner_title_display', true );
$banner_title = get_post_meta( $post->ID, 'inspiry_meta_banner_title', true );

if( $banner_title_display != 'hide' ){
    if(empty($banner_title)){
        $banner_title = get_the_title($post->ID);
    }
}

?>
<div class="page-banner" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo get_banner_image(); ?>'); background-size: cover;">
    <?php
    if( !empty( $banner_title ) && ( $banner_title_display != 'hide' ) ){
        ?>
        <div class="container fadeInLeft <?php echo inspiry_animation_class(); ?>">
            <h2 class="page-title"><?php echo $banner_title; ?></h2>
        </div>
        <?php
    }
    ?>
</div>