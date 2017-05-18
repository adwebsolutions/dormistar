<?php
global $theme_options;
?>
<section class="home-features-two clearfix">

    <div class="section-top">

        <div class="container">

            <?php
            if ( !empty($theme_options['home_features_title']) || !empty($theme_options['home_features_description']) ) {
                ?>
                <header class="section-header">

                    <?php
                    if( !empty($theme_options['home_features_title']) ){
                        echo '<h2 class="section-title fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_features_title'] . '</h2>';
                    }

                    if( !empty($theme_options['home_features_description']) ){
                        echo '<p class="fade-in-up '.inspiry_animation_class().'">' . $theme_options['home_features_description'] . '</p>';
                    }
                    ?>

                </header>
            <?php
            }
            ?>

        </div>

    </div>


    <div class="section-bottom">

        <div class="container">

            <div class="row">

                <?php
                $home_features = $theme_options['home_features_2'];

                if (!empty($home_features)) {
                    $loop_counter = 0;
                    $features_count = count ( $home_features );
                    $features_col_count = inspiry_col_count( $features_count );
                    $feature_col_classes = inspiry_col_classes( $features_col_count );
                    foreach ($home_features as $feature) {

                        ?>
                        <article class="service <?php echo $feature_col_classes; ?> <?php echo inspiry_col_animation_class( $features_col_count, $loop_counter ) .' '. inspiry_animation_class(); ?>">
                            <?php
                            if( !empty($feature['image']) ) {
                                ?>
                                <figure>
                                    <?php
                                    if( !empty($feature['url']) ) {
                                        echo '<a href="'.$feature['url'].'" title="'.$feature['title'].'">';
                                        echo '<img src="'. $feature['image'] .'" alt="'.$feature['title'].'"/>';
                                        echo '</a>';
                                    }else{
                                        echo '<img src="'. $feature['image'] .'" alt="'.$feature['title'].'"/>';
                                    }
                                    ?>
                                </figure>
                                <?php
                            }

                            if( !empty( $feature['title'] ) ){
                                if( !empty( $feature['url'] ) ){
                                    echo '<h3><a href="'.$feature['url'].'" title="'.$feature['title'].'">'.$feature['title'].'</a></h3>';
                                }else{
                                    echo '<h3>'.$feature['title'].'</h3>';
                                }
                            }

                            if( !empty( $feature['description'] ) ){
                                echo '<p>'.$feature['description'].'</p>';
                            }
                            ?>
                        </article>
                        <?php
                        $loop_counter++;
                        inspiry_col_clearfix( $features_col_count, $loop_counter );

                    }
                }
                ?>

            </div>

        </div>

    </div>

</section>


