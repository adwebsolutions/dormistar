<?php
/*
*   Template Name: Checkout Template
*/

/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="page-content container">
    <div class="row">
        <div class="main col-xs-12" role="main">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    /* output page contents */
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div><!-- end of page content -->

<?php get_footer(); ?>