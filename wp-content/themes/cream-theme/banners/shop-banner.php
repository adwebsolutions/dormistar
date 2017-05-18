<?php
// We cannot provide title related settings here as title changes for shop, product category, product tag and other archive pages
?>
<div class="page-banner" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo get_shop_banner_image(); ?>'); background-size: cover;">
    <div class="container fadeInLeft <?php echo inspiry_animation_class(); ?>">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
        <h2 class="page-title"><?php woocommerce_page_title(); ?></h2>
        <?php endif; ?>
    </div>
</div>