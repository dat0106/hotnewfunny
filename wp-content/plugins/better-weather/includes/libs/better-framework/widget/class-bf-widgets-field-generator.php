<?php

class BF_Widgets_Field_Generator extends BF_Admin_Fields{

    /**
     * Holds Items Array
     *
     * @since 1.0
     * @access public
     * @var array|null
     */
    public $items;


    /**
     * Panel Values
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $values;


    /**
     * Constructor Function
     *
     * @param array $options
     * @param array $values
     * @internal param $id
     * @internal param $ (array)  $options Panel All Options
     * @internal param $ (string) $id        Panel ID
     * @internal param $ (array)  $values    Panel Saved Values
     *
     * @since 1.0
     * @access public
     * @return \BF_Widgets_Field_Generator
     */
    public function __construct( array $options, $values = array() ){
        $default_options = array(
            'templates_dir'	=>	 BF_PATH . 'widget/widgets/templates/',
        );
        $options = array_merge( $default_options, $options );

        // Parent Constructor
        parent::__construct( $options );

        $this->items  = $options;
        $this->values = $values;
    }


    /**
     * Display HTML output of one field
     *
     * @param $field
     * @return string
     */
    public function get_field( $field ){

        $field['value'] = isset( $this->values[ $field['attr_id'] ] ) ? $this->values[ $field['attr_id'] ] : false;
        if( $field['value'] == false && isset( $field['std'] ) )
            $field['value'] = $field['std'];

        if( !in_array( $field['type'], $this->supported_fields ) )
            return '';

        if( $field['type'] == 'repeater' ){
            $field['widget_field'] = true;
        }

        return $this->section(
            call_user_func(
                array( $this, $field['type'] ),
                $field
            ),
            $field
        );

    }


    /**
     * Display HTML output of widget fields array
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function get_fields(){

        $output	= '';

        foreach( $this->items['fields'] as $field ){
            $output .= $this->get_field( $field );
        }

        return $output;
    }

}