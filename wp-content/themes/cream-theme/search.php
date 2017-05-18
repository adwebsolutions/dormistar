<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/search-banner');
?>

    <!-- start of page content -->
    <div class="page-content container">
        <div class="row">
            <div class="main col-md-8" role="main" >
                <h2 class="entry-title"><?php _e('Search Results for:', 'framework');
                    echo ' ';
                    the_search_query(); ?></h2>
                <hr/>
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