<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/archive-banner');
?>

    <!-- start of page content -->
    <div class="page-content container">
        <div class="row">
            <div class="main col-md-8" role="main">
                <?php get_template_part('loop'); ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- end of page content -->

    <?php
/* Include Footer */
get_footer();
?>