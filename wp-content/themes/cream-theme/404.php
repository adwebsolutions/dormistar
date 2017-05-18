<?php
/* Include Header */
get_header();

/* Include Banner */
get_template_part('banners/default-banner');
?>

<!-- start of page content -->
<div class="container-fluid">
    <div class="row">
        <div class="main col-xs-12" role="main">
            <div class="jumbotron">
                <h1>4<span>0</span>4</h1>
                <div class="entry-content">
                    <p><?php _e('Look like something went wrong! The page you were looking for is not here', 'framework'); ?></p>
                    <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Visit Homepage','framework'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div><!-- end of page content -->

<?php get_footer(); ?>

