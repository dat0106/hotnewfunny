<?php

class BF_Menu_Field_Generator extends BF_Admin_Fields{

    /**
     * Holds Fields Array
     *
     * @since 1.0
     * @access public
     * @var array|null
     */
    public $fields;


    /**
     * Menu item that contains values
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $menu_item;


    /**
     * Constructor Function
     *
     * @param array $options
     * @param array $fields
     * @param object $menu_item
     *
     * @since 1.0
     * @access public
     * @return \BF_Menu_Field_Generator
     */
    public function __construct( array $options, array $fields, $menu_item = null ){
        $default_options = array(
            'templates_dir'	=>	 BF_PATH . 'menu/templates/',
        );
        $options = array_merge( $default_options, $options );

        // Parent Constructor
        parent::__construct( $options );

        $this->fields  = $fields;

        $this->menu_item = $menu_item;
    }


    /**
     * Display HTML output of fields
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function get_fields(){

        $output	 = '';

        foreach( $this->fields as $key => $field ){

            if( isset( $field['panel-id'] ) ){
                $std = Better_Framework::options()->get_std_field_id( $field['panel-id'] );
            }else{
                $std = 'std';
            }

            $field['value'] = isset( $this->menu_item->{$field['id']} ) ? $this->menu_item->{$field['id']} : false;

            if( $field['value'] == false && isset( $field[$std] ) )
                $field['value'] = $field[$std];

            if( !in_array( $field['type'], $this->supported_fields ) )
                continue;

            // for image checkbox sortable option
            if( isset($field['is_sortable']) && ($field['is_sortable']=='1') )
                $field['section_class'] .=' is-sortable';

            $field['input_name'] = $this->generate_field_ID( $key , $this->menu_item->ID );

            $output .= $this->section(
                call_user_func(
                    array( $this, $field['type'] ),
                    $field
                ),
                $field
            );

        } // foreach

        return $output;
    }


    /**
     * Generate valid names for fields
     *
     * @param $key
     * @param $parent_id
     * @return string
     */
    public function generate_field_ID( $key , $parent_id ){
        return  'menu-item-' . esc_attr($key) . '[' . $parent_id . ']';
    }

}