<div class="page-banner" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo get_banner_image(); ?>'); background-size: cover;">
    <div class="container fadeInLeft <?php echo inspiry_animation_class(); ?>">
        <?php
        $post = $posts[0]; // Hack. Set $post so that the_date() works.

        if ( is_category() ) {
            ?><h1 class="page-title"><?php echo single_cat_title('', false); ?></h1><?php
        } elseif ( is_tag() ) {
            ?><h1 class="page-title"><?php echo single_tag_title('', false); ?></h1><?php
        } elseif ( is_day() ) {
            ?><h1 class="page-title"><?php printf(__('%s', 'framework'), get_the_date()); ?></h1><?php
        } elseif ( is_month() ) {
            ?><h1 class="page-title"><?php printf(__('%s', 'framework'), get_the_date('F Y')); ?></h1><?php
        } elseif ( is_year() ) {
            ?><h1 class="page-title"><?php printf(__('%s', 'framework'), get_the_date('Y')); ?></h1><?php
        } elseif ( is_author() ) {
            $current_author = $wp_query->get_queried_object();
            ?><h1 class="page-title"><?php echo $current_author->display_name; ?></h1><?php
        } elseif ( isset($_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
            ?><h1 class="page-title"><?php _e('Blog', 'framework') ?> <?php _e('Archives', 'framework') ?></h1><?php
        }
        ?>
    </div>
</div>