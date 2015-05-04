<?php

class Better_Gallery_Slider {


    function __construct(){

        // Extends gallery fields
        add_action('print_media_templates', array( $this, 'extend_gallery_settings' ) );

        add_filter( 'post_gallery', array( $this, 'my_gallery_shortcode' ), 10, 4 );

    }


    /**
     * Extends gallery fields and add new ones for better gallery slider
     */
    function extend_gallery_settings(){
        ?>
        <script type="text/html" id="tmpl-bgs-gallery-setting">
            <label class="setting">
                <span><?php _e( 'Gallery Type', 'better-studio' ); ?></span>
                <select data-setting="bgs_gallery_type">
                    <option value="">Default </option>
                    <option value="slider">Better Gallery Slider</option>
                </select>
            </label>

            <label class="setting">
                <span><?php _e( 'Gallery Skin', 'better-studio' ); ?></span>
                <select data-setting="bgs_gallery_skin">
                    <option value="">Dark (Default)</option>
                    <option value="light">Light</option>
                    <option value="beige">Beige</option>
                </select>
            </label>

            <label class="setting">
                <span><?php _e( 'Gallery Title', 'better-studio' ); ?></span>
                <input type="text" value="" data-setting="bgs_gallery_title" />
            </label>
        </script>

        <script>
            jQuery(document).ready(function(){

                _.extend(wp.media.gallery.defaults, {
                    bgs_gallery_type: '',
                    bgs_gallery_skin: '',
                    bgs_gallery_title: ''
                });

                wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                    template: function(view){
                        return wp.media.template('gallery-settings')(view)
                        + wp.media.template('bgs-gallery-setting')(view);
                    }
                });

            });

        </script>
    <?php
    }


    /**
     * @param string $output - is empty !!!
     * @param $atts
     * @param bool $content
     * @param bool $tag
     * @return mixed
     */
    function my_gallery_shortcode( $output = '', $atts, $content = false, $tag = false ) {

        if( isset( $atts['bgs_gallery_type'] ) && $atts['bgs_gallery_type'] == 'slider' ){

            // Slider title
            if( isset( $atts['bgs_gallery_title'] ) ){
                $slider_title =  $atts['bgs_gallery_title'];
            }else{
                $slider_title =  '';
            }

            $image_ids = explode( ',', $atts['ids'] );

            // Check for valid images
            if( count( $image_ids ) == 1 and ! is_numeric( $image_ids[0] ) ){
                return $output;
            }

            $gallery_popup_id = rand( 100, 1000000000 );
            $js_gallery_images= array();
            $js_gallery_descs =  array();

            $gallery_class = '';

            if( isset( $atts['bgs_gallery_skin'] ) ){
                $gallery_class .= ' skin-' . $atts['bgs_gallery_skin'];
            }

            $new_output = '<div id="gallery-' . $gallery_popup_id . '" class="better-gallery ' . $gallery_class . '" data-gallery-id="' . $gallery_popup_id . '">
                <div class="gallery-title clearfix">
                    <span class="main-title">' . $slider_title .'</span>
                    <span class="next"><i class="fa fa-chevron-right"></i></span>
                    <span class="prev"><i class="fa fa-chevron-left"></i></span>
                    <span class="count"><i class="current">1</i> Of <i class="total">' . count( $image_ids ) .'</i></span>
                </div>
                <div class="fotorama" data-nav="thumbs" data-auto="false" data-ratio="' . ( Better_Mag::current_sidebar_layout() ? '16/7' : '16/5' ) . '">';


            foreach( $image_ids as $key => $image_id ){

                $image = $this->get_attachment_full_info( $image_id, 'bgs-375' );

                $image_full = $this->get_attachment_src( $image_id, 'full' );

                $image_thumb = $this->get_attachment_src( $image_id, 'post-thumbnail' );

                $new_output .= '<div data-thumb="'. $image_thumb['src'] . '">
                        <a href="'. $image_full['src'] . '" class="slide-link" data-not-rel="true"><img data-id="'. $key . '" src="'. $image['src'] . '"></a><div class="slide-title-wrap">' ;

                if( ! empty( $image['caption'] ) )
                    $new_output .= '<span class="slide-title">' . $image['caption'] . '</span>';

                if( ! empty( $image['alt'] ) )
                    $new_output .= '<br><span class="slide-copy">' . $image['alt'] . '</span>';

                $new_output .= '</div></div>';

                $js_gallery_images[] = "'" . $image_full['src'] . "'" ;
                $js_gallery_descs[] = "'" . $image['caption'] . "'";

            }

            $new_output .= '</div></div>';

            $new_output .= "<script>" ;
            $new_output .= 'var prt_gal_img_' . $gallery_popup_id . " = [" . implode( ',', $js_gallery_images ) . "]; ";
            $new_output .= 'var prt_gal_cap_' . $gallery_popup_id . " = [" . implode( ',', $js_gallery_descs ) . "]; ";
            $new_output .= "</script>";

            return $new_output;
        }

        return $output;
    }


    /**
     * Used for retrieving full information of attachment
     *
     * @param $id
     * @param string $size
     * @return array
     */
    function get_attachment_full_info( $id, $size = 'full' ){

        $attachment = get_post( $id );

        $data = $this->get_attachment_src( $id, $size );

        return array (
            'alt'           =>  get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption'       =>  $attachment->post_excerpt,
            'description'   =>  $attachment->post_content,
            'href'          =>  get_permalink( $attachment->ID ),
            'src'           =>  $data['src'],
            'title'         =>  $attachment->post_title,
            'width'         =>  $data['width'],
            'height'        =>  $data['height']
        );

    }


    /**
     * Safe wrapper for getting an attachment image url + size information.
     *
     * @param $id
     * @param string $size
     * @return mixed
     */
    function get_attachment_src( $id, $size = 'full' ){

        $image_src_array = wp_get_attachment_image_src( $id, $size );

        $data = array();

        if( empty( $image_src_array[0] ) ){
            $data['src'] = '';
        }else{
            $data['src'] = $image_src_array[0];
        }

        if( empty( $image_src_array[1] ) ){
            $data['width'] = '';
        }else{
            $data['width'] = $image_src_array[1];
        }

        if( empty($image_src_array[2]) ){
            $data['height'] = '';
        }else{
            $data['height'] = $image_src_array[2];
        }

        return $data;
    }



}