<?php
global $theme_options;
$slides = $theme_options['slides'];

if (!empty($slides[0]['image'])) {
    ?>
    <div class="home-slider fadeInUp <?php echo inspiry_animation_class(); ?>">
        <div class="flexslider loading">
            <ul class="slides">
                <?php
                foreach ($slides as $slide) {
                    if (!empty($slide['image'])) {
                        ?>
                        <li>
                            <img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"/>

                            <div class="slide-description container <?php if( $theme_options['display_slide_bg'] ){ echo 'show-bg';}?>">

                                <?php if (!empty($slide['title'])) { ?>
                                    <h2><?php echo $slide['title']; ?></h2>
                                <?php } ?>

                                <div class="separator"></div>

                                <?php if (!empty($slide['description'])) { ?>
                                    <p><?php echo $slide['description']; ?></p>
                                <?php } ?>

                                <?php if (!empty($slide['url'])) { ?>
                                    <a href="<?php echo $slide['url']; ?>"><?php _e('EXPLORE MORE', 'framework'); ?></a>
                                <?php } ?>

                            </div>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
} else {
    get_template_part('banners/default-banner');
}
?>