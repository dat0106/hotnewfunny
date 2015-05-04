<?php

if( empty( $options['options'] ) )
    return;

$allowed_fields_in_repeater = array(
    'text',
    'textarea',
    'ajax_select',
    'image_radio',
    'image_upload',
    'color',
    'date',
    'select',
    'icon_select',
    'media',
    'checkbox',
    'media_image',
);

$counter = 0;

$name_format = empty( $options['input_name'] ) ? '%s[%d][%s]' : $options['input_name'];

if( empty( $options['value'] ) )
    $options['value'] = array(0);

// Add New Item Label
if(isset($options['add_label']) && !empty($options['add_label']))
    $add_label = $options['add_label'];
else
    $add_label = __( 'Add','better-studio' );

// Delete Item Label
if(isset($options['delete_label']) && !empty($options['delete_label']))
    $delete_label = $options['delete_label'];
else
    $delete_label = __('Delete','better-studio');

// Item title
if(isset($options['item_title']) && !empty($options['item_title']))
    $item_title = $options['item_title'];
else
    $item_title = __('Item','better-studio');


echo '<!-- Repeater Container --><div class="bf-repeater-items-container bf-clearfix">';

foreach( $options['value'] as $saved_key => $saved_val ){

    echo '<!-- Repeater Item --><div class="bf-repeater-item"><div class="bf-repeater-item-title"><h5>'.$item_title.'<span class="handle-repeater-item"></span><span class="bf-remove-repeater-item-btn"><span class="dashicons dashicons-trash"></span>'.$delete_label.'</span></div><div class="repeater-item-container bf-clearfix">';

    foreach( $options['options'] as $loop_key => $option_array ){

        if(
               empty( $option_array['id'] )
            || empty( $option_array['type'] )
            || !in_array( $option_array['type'], $allowed_fields_in_repeater )
        )
            continue;

        // Repeater in metabox
        if( isset( $options['metabox-field'] ) && $options['metabox-field'] ){
            $option_array['input_name'] = sprintf( $name_format, $options['metabox-id'], $options['id'], $counter, $option_array['id'] );
        }
        // Repeater in widgets
        elseif( isset( $options['widget_field'] ) ){
            $option_array['input_name'] = sprintf( $option_array['input_name'], $counter );
        }
        // General Repeater
        else{
            $option_array['input_name'] = sprintf( $name_format, $options['id'], $counter, $option_array['id'] );
        }


        $option_array['value'] = isset( $saved_val[$option_array['id']] ) ? $saved_val[$option_array['id']] : false;

        echo call_user_func(
            array( $this, 'section' ),
            call_user_func(
                array( $this, $option_array['type'] ),
                $option_array
            ),
            $option_array
        );
    }

    echo '</div></div><!-- /Repeater Item -->';

    $counter++;

}
echo '</div><!-- / Repeater Container -->';

// HTML Stuff for when user is adding new item to repeater
$script = Better_Framework::html()->add( 'script' )->type( 'text/html' );
ob_start();
echo '<!-- Repeater Item --><div class="bf-repeater-item"><div class="bf-repeater-item-title"><h5>'.$item_title.'<span class="handle-repeater-item"></span><span class="bf-remove-repeater-item-btn"><span class="dashicons dashicons-trash"></span>'.$delete_label.'</span></div><div class="repeater-item-container bf-clearfix">';
foreach( $options['options'] as $script_option ){
    if( !in_array( $script_option['type'], $allowed_fields_in_repeater ) )
        continue;

    // Repeater in metabox
    if( isset( $options['metabox-field'] ) && $options['metabox-field'] ){
        $script_option['input_name'] = "|_to_clone_{$options['metabox-id']}-child-{$options['id']}-num-{$script_option['id']}|";
    }
    // Repeater in widgets
    elseif( isset( $options['widget_field'] ) ){
        $script_option['input_name'] = "|_to_clone_{$options['id']}-num-{$script_option['id']}|";
    }
    // General Repeater
    else{
        $script_option['input_name'] = "|_to_clone_{$options['id']}-num-{$script_option['id']}|";
    }

    $script_option['value'] = false;
    echo call_user_func(
        array( $this, 'section' ),
        call_user_func(
            array( $this, $script_option['type'] ),
            $script_option
        ),
        $script_option
    );
}
echo '</div></div><!-- /Repeater Item -->';
$script->text( ob_get_clean() );
echo $script->display();


// Add new item to repeater button
$new_btn = Better_Framework::html()->add( 'button' )->class( 'bf-clone-repeater-item bf-button button' )->text( $add_label );

// Repeater in widgets
if( isset( $options['widget_field'] ) ){
    $new_btn = Better_Framework::html()->add( 'button' )->class( 'bf-widget-clone-repeater-item bf-button button' )->text( $add_label );
}
// General Repeater
else{
    $new_btn = Better_Framework::html()->add( 'button' )->class( 'bf-clone-repeater-item bf-button button' )->text( $add_label );
}

if( !empty( $options['clone-name-format'] ) )
    $new_btn->data( 'name-format', $options['clone-name-format'] );

echo $new_btn->display();