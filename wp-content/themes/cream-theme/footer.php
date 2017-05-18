<?php
global $theme_options;
if( $theme_options['display_tweet_above_footer'] ){

    if ( !empty($theme_options['twitter_username']) &&
         !empty($theme_options['consumer_key']) &&
         !empty($theme_options['consumer_secret']) &&
         !empty($theme_options['access_token']) &&
         !empty($theme_options['access_token_secret']) ) {

        /** Require the twitter class */
        if ( !class_exists('Twitter') )
            require_once get_template_directory().'/include/twitter/twitter.php';

        $twitter = new Twitter( $theme_options['consumer_key'],
                                $theme_options['consumer_secret'],
                                $theme_options['access_token'],
                                $theme_options['access_token_secret'] );

        ?>
        <div class="twitter-feeds">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="twitter-icon fade-in-up <?php echo inspiry_animation_class(); ?>">
                            <i class="fa fa-twitter img-circle"></i>
                        </div>
                        <?php
                        /** Get Tweets */
                        $tweets = $twitter->get_tweets( $theme_options['twitter_username'] );

                        if( $tweets ){
                            foreach ( $tweets as $tweet ) {
                                ?>
                                <p class="inline_tweet fade-in-up <?php echo inspiry_animation_class(); ?>">
                                    <?php echo $twitter->format_tweet( $tweet->text ); ?>
                                </p>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>

<!-- Start Footer -->
<footer class="footer">

    <div class="footer-top container">

        <div class="row">

            <div class="col-lg-8 col-xs-12">

                <div class="footer-menu-wrapper fade-in-left <?php echo inspiry_animation_class(); ?>">
                    <nav class="footer-nav clearfix">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'container' => false,
                            'menu_class' => 'clearfix'
                        ));
                        ?>
                    </nav>
                </div>

                <?php
                if ( $theme_options['display_footer_contact_info'] ) {
                    ?>
                    <div class="contact-details clearfix fade-in-left <?php echo inspiry_animation_class(); ?>">
                        <?php
                        if ( !empty($theme_options['footer_address']) ) {
                            ?>
                            <address><i class="fa fa-home"></i><?php echo $theme_options['footer_address']; ?></address>
                            <?php
                        }
                        if ( !empty($theme_options['footer_phone']) ) {
                            ?>
                            <a class="phone-number" href="tel:<?php echo preg_replace('/\D+/', '', str_replace( '+', '00', $theme_options['footer_phone'] ) ); ?>"><i class="fa fa-mobile"></i><?php echo $theme_options['footer_phone']; ?></a>
                            <?php
                        }
                        if ( isset( $theme_options['footer_email'] ) && is_email( $theme_options['footer_email'] ) ) {
                            ?>
                            <span class="email"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo antispambot( $theme_options['footer_email'] ); ?>"><?php echo antispambot( $theme_options['footer_email'] ); ?></a></span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
            if ( $theme_options['display_footer_social_icons'] ) {
                ?>
                <div class="col-lg-4 col-xs-12">
                    <div class="social-networks fade-in-right <?php echo inspiry_animation_class(); ?>">
                        <p class="invitation"><?php echo $theme_options['social_icons_title']; ?></p>
                        <ul class="social_networks clearfix">
                            <?php
                            if (!empty($theme_options['twitter_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['twitter_url'] . '"><i class="fa fa-twitter fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['facebook_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['facebook_url'] . '"><i class="fa fa-facebook fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['google_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['google_url'] . '"><i class="fa fa-google-plus fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['linkedin_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['linkedin_url'] . '"><i class="fa fa-linkedin fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['instagram_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['instagram_url'] . '"><i class="fa fa-instagram fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['youtube_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['youtube_url'] . '"><i class="fa fa-youtube fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['skype_username'])) {
                                echo '<li><a target="_blank" href="skype:' . $theme_options['skype_username'] . '?add"><i class="fa fa-skype fa-lg"></i></a></li>';
                            }
                            if (!empty($theme_options['rss_url'])) {
                                echo '<li><a target="_blank" href="' . $theme_options['rss_url'] . '"><i class="fa fa-rss fa-lg"></i></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="footer-bottom fadeInUp <?php echo inspiry_animation_class(); ?>">
        <div class="container">
            <?php
            if ( !empty($theme_options['footer_copyright']) ) {
                ?><p class="copyright-text"><?php echo $theme_options['footer_copyright'] ?></p><?php
            }

            if ( $theme_options['display_scroll_top'] ) {
                ?><a href="#top" id="scroll-top"></a><?php
            }
            ?>
        </div>
    </div>

</footer><!-- End Footer -->

<?php wp_footer(); ?>
</body>
</html>