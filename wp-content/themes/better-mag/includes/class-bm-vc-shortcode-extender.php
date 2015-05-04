<?php

/**
 * Wrapper for WPBakeryShortCode Class for handling editor
 */
class BM_VC_Shortcode_Extender extends BF_VC_Shortcode_Extender{

    function __construct( $settings ){

        // Base BF Class For Styling
        if( isset( $settings['class'] ) ){
            $settings['class'] .= ' bm-vc-field';
        }else{
            $settings['class'] = 'bm-vc-field';
        }

        parent::__construct( $settings );
    }

}
