<div class="service-plans">

    <?php
    global $theme_options;

    if ( ( !empty( $theme_options['home_services_title'] ) ) || ( !empty( $theme_options['home_services_description'] ) ) ) {
        ?>
        <div class="container">
            <header class="section-header">
                <?php
                if ( !empty( $theme_options['home_services_title'] ) ) {
                    echo '<h2 class="section-title fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_services_title'] . '</h2>';
                }
                if ( !empty( $theme_options['home_services_description'] ) ) {
                    echo '<p class="fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_services_description'] . '</p>';
                }
                ?>
            </header>
        </div>
        <?php
    }
    ?>

    <div class="container">

        <div class="row">
            <?php

            $home_services = $theme_options['home_services'];

            if (!empty($home_services)) {
                $home_services_count = count( $home_services );
                $services_col_count = inspiry_col_count( $home_services_count );
                $col_classes = inspiry_col_classes( $services_col_count );
                $loop_counter = 0;
                foreach ($home_services as $service) {
                    ?>
                    <section class="<?php echo $col_classes; ?> <?php echo inspiry_col_animation_class( $services_col_count, $loop_counter ) .' '. inspiry_animation_class(); ?>">
                        <?php
                        if( !empty($service['image']) ) {
                            ?>
                            <div class="image-container">
                                <?php
                                if( !empty($service['url']) ) {
                                    echo '<a href="'.$service['url'].'" title="'.$service['title'].'">';
                                    echo '<img src="'. $service['image'] .'" alt="'.$service['title'].'"/>';
                                    echo '</a>';
                                }else{
                                    echo '<img src="'. $service['image'] .'" alt="'.$service['title'].'"/>';
                                }
                                ?>
                            </div>
                        <?php
                        }

                        if( !empty( $service['title'] ) ){
                            if( !empty( $service['url'] ) ){
                                echo '<h3 class="title"><a href="'.$service['url'].'" title="'.$service['title'].'">'.$service['title'].'</a></h3>';
                            }else{
                                echo '<h3 class="title">'.$service['title'].'</h3>';
                            }
                        }

                        if( !empty( $service['description'] ) ){
                            echo '<p>'.$service['description'].'</p>';
                        }
                        ?>

                    </section>

                    <?php
                    $loop_counter++;
                    inspiry_col_clearfix( $services_col_count, $loop_counter );
                }
            }
            ?>

        </div>

    </div>

</div><!-- end of services section -->