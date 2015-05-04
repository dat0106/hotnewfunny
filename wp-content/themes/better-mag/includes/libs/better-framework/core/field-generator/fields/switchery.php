<?php
$hidden = Better_Framework::html()->add( 'input' )->type( 'hidden' )->name( $options['input_name'] )->val('0');

$checkbox = Better_Framework::html()->add( 'input' )->type( 'checkbox' )->name( $options['input_name'] )->val('1')->class('js-switch');
if( $options['value'] )
    $checkbox->attr( 'checked', 'checked');

if( isset( $options['input_class'] ) )
    $checkbox->class($options['input_class']);

echo $hidden->display();
echo $checkbox->display();
