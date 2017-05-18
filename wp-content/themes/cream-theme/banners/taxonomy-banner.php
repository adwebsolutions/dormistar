<div class="page-banner" style="background-repeat: no-repeat; background-position: center top; background-image: url('<?php echo get_banner_image(); ?>'); background-size: cover;">
    <?php
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if( $current_term ){
        ?>
        <div class="container fadeInLeft <?php echo inspiry_animation_class(); ?>">
            <h2 class="page-title"><?php echo $current_term->name; ?></h2>
        </div>
        <?php
    }
    ?>
</div>