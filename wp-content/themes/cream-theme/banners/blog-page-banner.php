<?php
/* If posts page is set in Reading Settings */
$page_for_posts = get_option('page_for_posts');
if($page_for_posts){
    // Banner Title
    $banner_title_display = get_post_meta( $page_for_posts, 'inspiry_meta_banner_title_display', true );
    $banner_title = get_post_meta( $page_for_posts, 'inspiry_meta_banner_title', true );
    if( $banner_title_display != 'hide' ){
        if(empty($banner_title)){
            $banner_title = get_the_title( $page_for_posts );
        }
    }
    // Banner Image
    $banner_image_id = get_post_meta( $page_for_posts, 'inspiry_meta_banner_image', true );
    if($banner_image_id){
        $banner_image_path = wp_get_attachment_url($banner_image_id);
    }else{
        $banner_image_path = get_default_banner();
    }
}else{
    $banner_title = __('Blog', 'framework');
    $banner_title_display = 'show';
    $banner_image_path = get_default_banner();
}
?>
<div class="page-banner" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo $banner_image_path; ?>'); background-size: cover;">
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