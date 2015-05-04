<?php

/**
 * Handle Base Custom CSS Functionality in BetterFramework
 */
abstract class BF_Custom_CSS{

    /**
     * Contain all css's that must be generated
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Contain final css that rendered.
     *
     * @var string
     */
    protected $final_css = '';


    /**
     * Contain Fonts That Must Be Import In Top Of CSS
     *
     * @var array
     */
    protected $fonts = array();


    /**
     * Used For Adding New Font To Fonts Queue
     *
     * @param string $family
     * @param string $variants
     * @param string $subsets
     * @param bool $google_font
     * @param string $url
     */
    public function set_fonts( $family = '', $variants = '', $subsets = '', $google_font = true, $url = '' ){

        if( $google_font ){

            // If Font Currently is in Queue Then Add New Variant Or Subset
            if( isset( $this->fonts[$family] ) ){

                if( ! in_array( $variants, $this->fonts[$family]['variants'] ) ){
                    $this->fonts[$family]['variants'][] = $variants;
                }

                if( ! in_array( $subsets, $this->fonts[$family]['subsets'] ) ){
                    $this->fonts[$family]['subsets'][] = $subsets;
                }

            }
            // Add New Font to Queue
            else{
                $this->fonts[$family] = array(
                    'variants'   =>  array( $variants ),
                    'subsets'   =>  array( $subsets ),
                    'is_google_font'   =>  $google_font,
                );
            }

        }

    }


    /**
     * Used For Generating Fonts Importer
     */
    public function render_fonts( $format = 'import' ){

        if( ! count( $this->fonts ) ) return '';

        $output = array(); // Final Out Put CSS

        $out_fonts = array(); // Array of Fonts, Each inner element one @import for separating subsets
        $out_fonts['main'] = array();

        // Create Each Font CSS
        foreach( $this->fonts as $family => $font){

            // Generate CSS For Google Fonts
            if( $font['is_google_font'] ){

                $_font_have_subset = false;

                $_font = str_replace( ' ', '+', $family );

                if( implode( ',', $font['variants'] ) != '' ){
                    $_font .= ':' . implode( ',', $font['variants'] );
                }

                // Remove Latin Subset because default subset is latin!
                // and if font have other subset then we make separate @import.
                foreach( $font['subsets'] as $key => $value ){
                    if( $value == 'latin' ){
                        unset( $font['subsets'][$key] );
                    }
                }
                if( implode( ',', $font['subsets'] ) != '' ){
                    $_font_have_subset = true;
                    $_font .= '&subset=' . implode( ',', $font['subsets'] );
                }

                // no specific subset
                if( ! $_font_have_subset  ){
                    array_push($out_fonts['main'] ,$_font);
                }else{
                    $out_fonts[][] = $_font;
                }

            }

        }

        if( $format == 'url' ){

            $final_fonts = array();
            foreach( $out_fonts as $key => $out_font ){
                $final_fonts[] = 'http://fonts.googleapis.com/css?family=' . implode( '|', $out_font );
            }

            return $final_fonts;
        }
        else{
            // Make Final @imports
            foreach( $out_fonts as $out_font ){
                $output .= '@import url(http://fonts.googleapis.com/css?family=' . implode( '|', $out_font ) . ');' . "\n";
            }

            if( ! empty( $output ) ){
                $output .= "\n";
            }
        }

        return $output;
    }

    /**
     * Add new line to active fields
     */
    private function add_new_line(){
        $this->fields[] = array( 'newline' => true );
    }


    /**
     * Render a block array to css code
     */
    private function render_block( $block , $value='' , $add_to_final = true ){
        $output = '';

        $after_value ='';

        $after_block ='';

        // Uncompressed in dev mode
        if( defined( 'BF_DEV_MODE' ) && BF_DEV_MODE ){
            $ln_char = "\n";
            $tab_char = "\t";
        }else{
            $ln_char = "";
            $tab_char = "";
        }


        if( isset( $block['newline'] ) ){
            $output .=  "\r\n";
        }

        if( isset( $block['comment'] ) || !empty( $block['comment'] ) ){
            $output .= '/* '. $block['comment'] . ' */' . "\r\n";
        }

        // Filters
        if( isset( $block['filter'] ) ){

            // WooCommerce Active Filter
            if( isset( $block['filter']['woocommerce'] ) && ! function_exists( 'is_woocommerce' ) ){
                return '';
            }

            // bbPress Active Filter
            if( isset( $block['filter']['bbpress'] ) && ! class_exists( 'bbpress' ) ){
                return '';
            }

            // BuddyPress Active Filter
            if( isset( $block['filter']['buddypress'] ) && ! function_exists( 'bp_is_active' ) ){
                return '';
            }

        }

        // Before than css code. For example used for adding media queries!.
        if( isset( $block['before'] ) ){
                $output .= $block['before']  . $ln_char;
        }

        // Prepare Selectors.
        if( isset( $block['selector'] ) ){
            if( ! is_array( $block['selector'] ) ){
                $output .= $block['selector'] . '{' . $ln_char;
            }else{
                $output .= implode( ',' . $ln_char , $block['selector'] ) . '{' . $ln_char;
            }
        }

        // Prepare Value For Font Field
        if( isset( $block['type'] ) && $block['type'] == 'font' ){

            // If font is not enable then don't echo css
            if( isset( $value['enable'] ) && ! $value['enable'] ){
                return '';
            }

            $output .= $tab_char . 'font-family:' . $value['family'] . ';' . $ln_char;

            if( preg_match( '/\d{3}\w./i', $value['variant'] ) ){
                $pretty_variant = preg_replace( '/(\d{3})/i', '${1} ', $value['variant'] );
                $pretty_variant = explode(' ', $pretty_variant);
            }else{
                $pretty_variant[] = $value['variant'];
            }

            if( isset( $pretty_variant[0] ) )
                $output .= $tab_char . 'font-weight:' . $pretty_variant[0] . ';' . $ln_char;

            if( isset( $pretty_variant[1] ) )
                $output .= $tab_char . 'font-style:' . $pretty_variant[1] . ';' . $ln_char;

            if( isset(  $value['line_height']) && ! empty( $value['line_height'] ) )
                $output .= $tab_char . 'line-height:' . $value['line_height'] . 'px;' . $ln_char;

            if( isset( $value['size'] ) )
                $output .= $tab_char . 'font-size:' . $value['size'] . 'px;' . $ln_char;

            if( isset( $value['align'] ) )
                $output .= $tab_char . 'text-align:' . $value['align'] . ';' . $ln_char;

            if( isset( $value['transform'] ) )
                $output .= $tab_char . 'text-transform:' . $value['transform'] . ';' . $ln_char;

            if( isset( $value['color'] ) )
                $output .= $tab_char . 'color:' . $value['color'] . ';' . $ln_char;

            // Add Google Font To Fonts Queue
            $this->set_fonts( $value['family'], $value['variant'], $value['subset'], true );
        }

        // prepare value for "background-image" type
        if( isset( $block['type'] ) && $block['type'] == 'background-image' ){

            if( $value['img'] == '' ) return '';

            if( $value['type'] == 'cover' ){
                $after_value .= $tab_char . 'background-repeat: no-repeat;background-attachment: fixed; background-position: center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover; background-size: cover;'
                    . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\')";'
                    . $ln_char;

                $value = 'url('. $value['img'] .')';
            }else{
                $after_value .= $tab_char . 'background-repeat:' . $value['type'] . ';' . $ln_char;
                $value = 'url('. $value['img'] .')';
            }

        }

        // prepare value for "color" type
        if( isset( $block['type'] ) && $block['type'] == 'color' ){

            if( preg_match( '/(%%value[-|+]\d*%%)/', $block['value'], $chanage) ){

                Better_Framework::factory('color');

                $color_change = $chanage[0];

                $color_change = BF_Color::change_color( $block['value'], intval( $color_change ) );

                $after_value .= preg_replace( '/(%%value[-|+]\d*%%)/', $color_change, $block['value'] );

                unset( $block['value'] );
            }

        }

        // prepare value for "border" type
        if( isset( $block['type'] ) && $block['type'] == 'border' ){

            if( isset( $value['all'] ) ){

                $output .= $tab_char . 'border:';

                if( isset( $value['all']['width'] ) ){
                    $output .= $value['all']['width'] .'px ';
                }
                if( isset( $value['all']['style'] ) ){
                    $output .= $value['all']['style'] . ' ';
                }
                if( isset( $value['all']['color'] ) ){
                    $output .= $value['all']['color']. ' ';
                }

                $output .= ';' . $ln_char;

            }else{

                if( isset( $value['top'] ) ){

                    $output .= $tab_char . 'border-top:';

                    if( isset( $value['top']['width'] ) ){
                        $output .= $value['top']['width'] .'px ';
                    }
                    if( isset( $value['top']['style'] ) ){
                        $output .= $value['top']['style'] . ' ';
                    }
                    if( isset( $value['top']['color'] ) ){
                        $output .= $value['top']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }

                if( isset( $value['right'] ) ){

                    $output .= $tab_char . 'border-right:';

                    if( isset( $value['right']['width'] ) ){
                        $output .= $value['right']['width'] .'px ';
                    }
                    if( isset( $value['right']['style'] ) ){
                        $output .= $value['right']['style'] . ' ';
                    }
                    if( isset( $value['right']['color'] ) ){
                        $output .= $value['right']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }
                if( isset( $value['bottom'] ) ){

                    $output .= $tab_char . 'border-bottom:';

                    if( isset( $value['bottom']['width'] ) ){
                        $output .= $value['bottom']['width'] .'px ';
                    }
                    if( isset( $value['bottom']['style'] ) ){
                        $output .= $value['bottom']['style'] . ' ';
                    }
                    if( isset( $value['bottom']['color'] ) ){
                        $output .= $value['bottom']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }

                if( isset( $value['left'] ) ){

                    $output .= $tab_char . 'border-left:';

                    if( isset( $value['left']['width'] ) ){
                        $output .= $value['left']['width'] .'px ';
                    }
                    if( isset( $value['left']['style'] ) ){
                        $output .= $value['left']['style'] . ' ';
                    }
                    if( isset( $value['left']['color'] ) ){
                        $output .= $value['left']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }


            }

        }

        // Prepare Properties
        if( isset( $block['prop'] ) ){

            foreach( (array) $block['prop'] as $key => $val ){

                // Customized value template for property
                if( strpos( $val, '%%value%%' ) !== false){

                    $output .= $tab_char . $key . ':';
                    $output .= str_replace( '%%value%%' , $value , $val ) . ';' . $ln_char;

                }
                // Simply set value to property
                else{

                    if( ! is_int( $key ) ){

                        $output .= $tab_char . $key . ':' . $val . ';' . $ln_char;

                    }else{

                        $output .= $tab_char . $val . ':' . $value . ';' . $ln_char;

                    }

                }
            }

        }

        // add after value
        if( isset($after_value) && $after_value != '' )
            $output .= $after_value;

        // Remove last ';'
        if( substr( $output, strlen($output)-1, 1 ) == ';'){
            $output = substr( $output, 0, strlen($output)-1 );
        }

        if( isset( $block['selector'] ) ){
            $output .= "}" . $ln_char;
        }

        // After css code. For example used for adding media queries!.
        if( isset( $block['after'] ) ){
            $output .= $block['after']  . $ln_char;
        }

        if( $add_to_final )
            $this->final_css .= $output;

        return $output;
    }


    /**
     * Render all fields css
     *
     * @return string
     */
    function render_css(){

        foreach( (array) $this->fields as $field ){

            // new line field
            if( isset( $field['newline'] ) ){
                $this->render_block( $field , '' );
                continue;
            }

            // continue when value in empty
            if( ! isset(  $field['value'] ) && empty( $field['value'] ) ) continue;

            $value = $field['value'];

            unset( $field['value'] );

            foreach( (array) $field as $block ){
                if( is_array( $block ) )
                    $this->render_block( $block , $value );
            }
        }

        return $this->final_css;
    }


    /**
     * display css
     */
    function display(){

        status_header( 200 );
        header( "Content-type: text/css; charset: utf-8" );

        $this->load_all_fields();

        $final_css = $this->render_css();

        echo $this->render_fonts();

        echo $final_css;

    }


    /**
     * Returns current css field id that integrated with style system
     *
     * @return string
     */
    function get_css_id( $panel_id ){

        // If panel haven't style feature
        if( ! isset( Better_Framework::options()->options[$panel_id]['fields']['style'] ) )
            return 'css';

        if( get_option( $panel_id . '_current_style' ) == 'default' )
            return 'css';
        else
            return 'css-' . get_option( $panel_id . '_current_style' );

    }
}