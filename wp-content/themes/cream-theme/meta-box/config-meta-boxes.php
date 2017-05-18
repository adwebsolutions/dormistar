<?php
/**
 * Register meta boxes
 */

add_filter( 'rwmb_meta_boxes', 'inspiry_register_meta_boxes' );

if( !function_exists( 'inspiry_register_meta_boxes' ) ) {
    function inspiry_register_meta_boxes() {

        // Make sure there's no errors when the plugin is deactivated or during upgrade
        if (!class_exists('RW_Meta_Box')) {
            return;
        }

        $meta_boxes = array();
        $prefix = 'inspiry_meta_';

        // Video Meta Box
        $meta_boxes[] = array(
            'id' => 'video-meta-box',
            'title' => __('Video Information', 'framework'),
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Video Embed Code', 'framework'),
                    'desc' => __('Provide the video embed code and remove the width and height attributes.', 'framework'),
                    'id' => "{$prefix}embed_code",
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '3'
                )
            )
        );


        // Link Meta Box
        $meta_boxes[] = array(
            'id' => 'url-meta-box',
            'title' => __('Link Information', 'framework'),
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Link Title Text', 'framework'),
                    'id' => "{$prefix}link_text",
                    'desc' => '',
                    'type' => 'text'
                ),
                array(
                    'name' => __('Link URL', 'framework'),
                    'id' => "{$prefix}link_url",
                    'desc' => '',
                    'type' => 'text'
                )
            )
        );


        // Gallery Meta Box for blog post
        $meta_boxes[] = array(
            'title' => __('Gallery Settings', 'framework'),
            'pages' => array('post'),
            'id' => 'gallery-meta-box',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Gallery Images', 'framework'),
                    'id' => "{$prefix}gallery",
                    'desc' => __('An image should have minimum width of 770px and minimum height of 480px ( Bigger size images will be cropped automatically).', 'framework'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 48
                )
            )
        );


        // Audio Meta Box
        $meta_boxes[] = array(
            'id' => 'audio-meta-box',
            'title' => __('Audio Settings', 'framework'),
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('MP3 Audio File', 'framework'),
                    'id' => "{$prefix}audio_mp3",
                    'desc' => __('Upload the MP3 audio file.', 'framework'),
                    'type' => 'file',
                    'max_file_uploads' => 1
                ),
                array(
                    'name' => __('OGG Audio File', 'framework'),
                    'id' => "{$prefix}audio_ogg",
                    'desc' => __('Upload the OGG audio file ( for fallback )', 'framework'),
                    'type' => 'file',
                    'max_file_uploads' => 1
                ),
                array(
                    'name' => __('WAV Audio File', 'framework'),
                    'id' => "{$prefix}audio_wav",
                    'desc' => __('Upload the WAV audio file ( for fallback )', 'framework'),
                    'type' => 'file',
                    'max_file_uploads' => 1
                ),
                array(
                    'name' => __('Audio Embed Code', 'framework'),
                    'desc' => __('If you do not have audio files to upload, then you can provide audio embed code here.', 'framework'),
                    'id' => "{$prefix}audio_embed_code",
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '3'
                )
            )
        );


        // Quote Meta Box
        $meta_boxes[] = array(
            'id' => 'quote-meta-box',
            'title' => __('Quote Information', 'framework'),
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Quote Text', 'framework'),
                    'id' => "{$prefix}quote_desc",
                    'desc' => __('Provide quote text here.', 'framework'),
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '3'
                ),
                array(
                    'name' => __('Quote Author', 'framework'),
                    'id' => "{$prefix}quote_author",
                    'desc' => __('Provide quote author name.', 'framework'),
                    'type' => 'text',
                )
            )
        );


        // testimonial meta box
        $meta_boxes[] = array(
            'id' => 'testimonial-meta-box',
            'title' => __('Testimonial', 'framework'),
            'pages' => array('testimonial'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Testimonial Text', 'framework'),
                    'id' => "the_testimonial",
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '3'
                ),
                array(
                    'name' => __('Testimonial Author', 'framework'),
                    'id' => "testimonial_author",
                    'type' => 'text',
                    'desc' => __('Example: John Doe', 'framework')
                ),
                array(
                    'name' => __('Testimonial Author URL', 'framework'),
                    'id' => "testimonial_author_link",
                    'type' => 'text',
                    'desc' => __('Example: http://www.authorsite.com', 'framework')
                )
            )
        );


        // portfolio item meta box
        $meta_boxes[] = array(
            'id' => 'portfolio-item-meta-box',
            'title' => __('Portfolio Settings', 'framework'),
            'pages' => array('portfolio-item'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Gallery Images', 'framework'),
                    'id' => "{$prefix}gallery",
                    'desc' => __('Recommended minimum width is 1170px and minimum height is 700px.', 'framework'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 48
                ),
                array(
                    'name' => __('Video Embed Code', 'framework'),
                    'desc' => __('Provide the video embed code and remove the width and height attributes. ( Video will be displayed only if no gallery image is uploaded )', 'framework'),
                    'id' => "{$prefix}embed_code",
                    'type' => 'textarea',
                    'cols' => '20',
                    'rows' => '3'
                )
            )
        );


        // Default banner Meta Box
        $default_banner_fields =  array(
            array(
                'name' => __( 'Banner Image', 'framework' ),
                'id' => "{$prefix}banner_image",
                'desc' => __('Banner image should have minimum width of 2000px and minimum height of 190px.', 'framework'),
                'type' => 'image_advanced',
                'max_file_uploads' => 1
            ),
            array(
                'name'      => __( 'Banner Title','framework' ),
                'id'        => "{$prefix}banner_title",
                'desc'      => __('Please provide the custom Banner Title, Otherwise the default title will be displayed.','framework'),
                'type'      => 'text'
            ),
            array(
                'name' => __( 'Banner Title Display', 'framework' ),
                'id'   => "{$prefix}banner_title_display",
                'desc'      => __('You can show or hide the banner title.','framework'),
                'type' => 'radio',
                'std'  => 'show',
                'options' => array(
                    'hide' => __( 'Hide', 'framework' ),
                    'show' => __( 'Show', 'framework' ),
                )
            )
        );


        $meta_boxes[] = array(
            'id' => 'default-banner-meta-box',
            'title' => __('Banner Settings', 'framework'),
            'pages' => array( 'post', 'portfolio-item', 'product' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $default_banner_fields
        );


        // page banner Meta Box
        $default_banner_fields[] = array(
            'name' => __( 'Page Title Display', 'framework' ),
            'id'   => "{$prefix}page_title_display",
            'desc'      => __('You can show or hide the page title.','framework'),
            'type' => 'radio',
            'std'  => 'show',
            'options' => array(
                'hide' => __( 'Hide', 'framework' ),
                'show' => __( 'Show', 'framework' ),
            )
        );


        $meta_boxes[] = array(
            'id' => 'page-banner-meta-box',
            'title' => __('Banner and Title Settings', 'framework'),
            'pages' => array( 'page' ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => $default_banner_fields
        );


        // apply a filter before returning meta boxes
        $meta_boxes = apply_filters('framework_theme_meta', $meta_boxes);

        return $meta_boxes;

    }
}