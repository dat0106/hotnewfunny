<?php

if( ! class_exists( "WPBakeryShortCode" ) ){
    class WPBakeryShortCode{

    }
}

/**
 * Wrapper for WPBakeryShortCode Class for handling editor
 */
class BF_VC_Shortcode_Extender extends WPBakeryShortCode{

    function __construct( $settings ){

        // Base BF Class For Styling
        if( isset( $settings['class'] ) ){
            $settings['class'] .= ' bf-vc-field';
        }else{
            $settings['class'] = 'bf-vc-field';
        }

        // Height Class For Styling
        if( isset( $settings['wrapper_height'] ) ){

            if( $settings['wrapper_height'] == 'full' ){
                $settings['class'] .= ' bf-full-height';
            }

        }


        parent::__construct( $settings );
    }

    /**
     * Prints out the styles needed to render the element icon for the back end interface.
     * Only performed if the 'icon' setting is a valid URL.
     */
    public function printIconStyles() {

        if ( ! filter_var( $this->settings( 'icon' ), FILTER_VALIDATE_URL ) ) {
            return;
        }

        echo "
            <style>
                .wpb_content_element[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] .wpb_element_wrapper,
                .vc_shortcodes_container[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                .wpb-content-layouts .wpb-layout-element-button[data-element='" . esc_attr( $this->settings['icon'] ) . "'] .vc-element-icon {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ");
                }
                #" . $this->settings['base'] . " .vc-element-icon{
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                li[data-element=" . $this->settings['base'] . "]{
                    background-color: #F9FDFF !important;
                    border-color: #9cd4eb !important;
                }
            </style>";
    }
}