<?php

$input = Better_Framework::html()->add('input')->type( 'hidden' )->name( $options['input_name'] )->class('bf-media-image-input');
if( !$options['value'] == false )
    $input->val( $options['value']);

if( isset( $options['input_class'] ) )
    $input->class($options['input_class']);

$media_title = empty( $options['media_title'] ) ? __( 'Upload', 'better-studio' ) : $options['media_title'];
$button_text = empty( $options['media_button'] ) ? __( 'Upload', 'better-studio' ) : $options['media_button'];

$upload_label = empty( $options['upload_label'] ) ? __( 'Upload', 'better-studio' ) : $options['upload_label'];
$remove_label = empty( $options['remove_label'] ) ? __( 'Remove', 'better-studio' ) : $options['remove_label'];


$upload_button = Better_Framework::html()->add( 'a' )->class( 'bf-button bf-media-image-upload-btn button' )->data( 'mediatitle', $media_title )->data( 'buttontext', $button_text );
$upload_button->text( $upload_label );

$remove_button = Better_Framework::html()->add( 'a' )->class( 'bf-button bf-media-image-remove-btn button' );
$remove_button->text( $remove_label );

if( $options['value'] == false )
    $remove_button->css('display:none');

echo $input->display();
echo $upload_button->display();
echo $remove_button->display();


if( $options['value'] != false ){
    echo '<div class="bf-media-image-preview">';
}else{
    echo '<div class="bf-media-image-preview" style="display: none">';
}

echo '<img src="' . $options['value'] . '" />';
echo '</div>';
