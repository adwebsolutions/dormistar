<?php
global $post;

/* Display Featured Image if Any */
inspiry_standard_thumbnail();

$mp3_id = get_post_meta($post->ID, 'inspiry_meta_audio_mp3', true);
$ogg_id = get_post_meta($post->ID, 'inspiry_meta_audio_ogg', true);
$wav_id = get_post_meta($post->ID, 'inspiry_meta_audio_wav', true);

if ($mp3_id) {
    $mp3_url = wp_get_attachment_url($mp3_id);
}

if ($ogg_id) {
    $ogg_url = wp_get_attachment_url($ogg_id);
}

if ($wav_id) {
    $wav_url = wp_get_attachment_url($wav_id);
}

if ( ( !empty($mp3_url) ) || ( !empty($ogg_url) ) || ( !empty($wav_url) ) ) {

    $source_parameters = "";

    if( !empty($mp3_url) ){
        $source_parameters .= ' mp3="'.$mp3_url.'"';
    }

    if( !empty($ogg_url) ){
        $source_parameters .= ' ogg="'.$ogg_url.'"';
    }

    if( !empty($wav_url) ){
        $source_parameters .= ' wav="'.$wav_url.'"';
    }

    echo '<div class="html5-audio-player-container">';
    echo do_shortcode('[audio'.$source_parameters.']');
    echo '</div>';

} else {

    $audio_embed_code = get_post_meta($post->ID, 'inspiry_meta_audio_embed_code', true); // audio embed code

    if (!empty($audio_embed_code)) {
        ?>
        <div class="audio-embed clearfix">
            <div class="audio-embed-wrapper clearfix">
                <?php echo stripslashes(htmlspecialchars_decode($audio_embed_code)); ?>
            </div>
        </div>
        <?php
    }
}
?>