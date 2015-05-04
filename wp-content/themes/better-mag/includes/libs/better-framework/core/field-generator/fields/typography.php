<?php
if( ! isset( $options['value']['family'] ) ){

    $options['value']['family'] = 'Lato';
    $options['value']['variant'] = '';

}

// prepare std id
if( isset( $panel_id ) ){

    $std_id = Better_Framework::options()->get_std_field_id( $panel_id );

}else {

    $std_id = 'css';

}


$enabled = false;

if( isset( $options[ $std_id ] ) ){
    if( isset( $options[ $std_id ]['enable'] ) ){
        $enabled = true;
    }
}
elseif( isset( $options[ 'std' ] ) ){
    if( isset( $options[ 'std' ]['enable'] ) ){
        $enabled = true;
    }
}

if( $enabled ){ ?>
    <div class="typo-enable-container"><?php

        $hidden = Better_Framework::html()->add( 'input' )->type( 'hidden' )->name( $options['input_name'] . '[enable]' )->val('0');

        $checkbox = Better_Framework::html()->add( 'input' )->type( 'checkbox' )->name( $options['input_name'] . '[enable]' )->val('1')->class('js-switch');
        if( $options['value']['enable'] )
            $checkbox->attr( 'checked', 'checked');

        echo $hidden->display();
        echo $checkbox->display();

        ?>
    </div>
<?php
} ?>
<div class="typo-fields-container bf-clearfix">
    <select name="<?php echo $options['input_name']; ?>[family]" id="<?php echo $options['input_name']; ?>-family" class="font-family <?php if( is_rtl() ) echo 'chosen-rtl'; ?>">
        <?php echo BF_Google_Fonts_Helper::get_fonts_family_option_elements( $options['value']['family'] ); ?>
    </select>

    <select name="<?php echo $options['input_name']; ?>[variant]" id="<?php echo $options['input_name']; ?>-variants" class="font-variants">
        <?php echo BF_Google_Fonts_Helper::get_font_variants_option_elements( $options['value']['family'], $options['value']['variant'] ); ?>
    </select>

    <select name="<?php echo $options['input_name']; ?>[subset]" id="<?php echo $options['input_name']; ?>-subset" class="font-subsets">
        <?php echo BF_Google_Fonts_Helper::get_font_subset_option_elements( $options['value']['family'], $options['value']['subset'] ); ?>
    </select>

    <?php

    $align = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['align'] ) ){
            $align = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['align'] ) ){
            $align = true;
        }
    }

    if( $align ){ ?>
        <span class="text-align-container"><?php _e('Text Align:', 'better-studio');
            $aligns = array(
                'inherit'   =>  'Inherit',
                'left'   =>  'Left',
                'center'   =>  'Center',
                'right'   =>  'Right',
                'justify'   =>  'Justify',
                'initial'   =>  'Initial',
            );
            ?>
            <select name="<?php echo $options['input_name']; ?>[align]" id="<?php echo $options['input_name']; ?>-align" >
                <?php foreach( $aligns as $key => $align ){
                    echo '<option value="'. $key . '" '. ( $key==$options['value']['align'] ? 'selected':'' ) . '>' . $align . '</option>';
                }?>
            </select>
        </span>
    <?php } ?>

    <?php

    $transform = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['transform'] ) ){
            $transform = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['transform'] ) ){
            $transform = true;
        }
    }

    if( $transform ){ ?>
        <span class="text-transform-container"><?php _e('Text Transform:', 'better-studio');
            $transforms = array(
                'none'   =>  'None',
                'capitalize'=>  'Capitalize',
                'lowercase'    =>  'Lowercase',
                'uppercase'    =>  'Uppercase',
                'initial'   =>  'Initial',
                'inherit'   =>  'Inherit',
            );
            ?>
            <select name="<?php echo $options['input_name']; ?>[transform]" id="<?php echo $options['input_name']; ?>-transform" class="text-transform">
                <?php foreach( $transforms as $key => $transform ){
                    echo '<option value="'. $key . '" '. ( $key==$options['value']['transform'] ? 'selected':'' ) . '>' . $transform . '</option>';
                }?>
            </select>
        </span>
    <?php } ?>


    <?php

    $size = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['size'] ) ){
            $size = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['size'] ) ){
            $size = true;
        }
    }

    if( $size ){ ?>
        <span class="bf-field-with-suffix bf-field-with-prefix">
            <span class='bf-prefix-suffix bf-prefix'><?php _e('Size:', 'better-studio'); ?> </span><input type="text" name="<?php echo $options['input_name']; ?>[size]" value="<?php echo $options['value']['size']; ?>" class="font-size"/><span class='bf-prefix-suffix bf-suffix'>px</span>
        </span>
    <?php }



    $line_height = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['line_height'] ) ){
            $line_height = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['line_height'] ) ){
            $line_height = true;
        }
    }

    if( $line_height ){ ?>
        <span class="bf-field-with-suffix bf-field-with-prefix last">
            <span class='bf-prefix-suffix bf-prefix'><?php _e('Height:', 'better-studio'); ?> </span><input type="text" name="<?php echo $options['input_name']; ?>[line_height]" value="<?php echo $options['value']['line_height']; ?>" class="line-height"/><span class='bf-prefix-suffix bf-suffix'>px</span>
        </span>
    <?php }


    $color = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['color'] ) ){
            $color = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['color'] ) ){
            $color = true;
        }
    }

    if( $color ){

        echo '<span class="text-color-container">';

        $input   = Better_Framework::html()->add( 'input' )->type( 'text' )->name( $options['input_name'] . '[color]' )->class( 'bf-color-picker' );

        $preview = Better_Framework::html()->add( 'div' )->class( 'bf-color-picker-preview' );

        if( ! empty( $options['value']['color']  ) ){
            $input->value( $options['value']['color'] )->css('border-color', $options['value']['color']);
            $preview->css( 'background-color', $options['value']['color'] );
        }

        echo $input->display();
        echo $preview->display();
        echo '</span>';

    } ?>

</div>