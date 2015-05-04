<?php

/**
 * Taxonomies Field Generator For Admin
 */
class BF_Taxonomy_Front_End_Generator extends BF_Admin_Fields{

    /**
     * Holds Items Array
     *
     * @since 1.0
     * @access public
     * @var array|null
     */
    public $items;


    /**
     * Panel ID
     *
     * @since 1.0
     * @access public
     * @var string
     */
    public $id;


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
     * @param $id
     * @param array $values
     *
     * @since 1.0
     * @access public
     * @return \BF_Taxonomy_Front_End_Generator
     */
    public function __construct( array &$options, &$id, &$values = array() ){

        // Parent Constructor
        $generator_options = array(
            'templates_dir' => BF_PATH . 'taxonomy/templates/'
        );
        parent::__construct( $generator_options );

        $this->items  = $options;
        $this->id	  = $id;
        $this->values = $values;
    }


    /**
     * Make input name from options variable
     *
     * @param (array) $options Options array
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function input_name( &$options ){

        $id   = @$options['id'];

        $type = @$options['type'];

        switch( $type ){

            case( 'repeater' ):
                return "bf-term-meta[%s][%d][%s]";
                break;

            default:
                return "bf-term-meta[{$id}]";
                break;
        }

    }


    /**
     * Used for generating fields
     *
     * TODO: Refactor this
     */
    public function callback(){

        $wrapper   	   = Better_Framework::html()->add( 'table' )->class( 'form-table bf-clearfix' )->data( 'id', $this->id );

        $container 	   = Better_Framework::html()->add( 'tbody' );

        foreach( $this->items as $field ){

            $field['input_name'] = $this->input_name( $field );
            $field['value'] = isset( $this->values[ @$field['id'] ] ) ? $this->values[ $field['id'] ] : false;
            if( $field['type'] == 'repeater' )
                $field['clone-name-format'] = 'bf-term-meta[%s][%d][%s]';

            if( !in_array( $field['type'], $this->supported_fields ) )
                continue;

            $container->text(
                $this->section(
                    call_user_func(
                        array( $this, $field['type'] ),
                        $field
                    ),
                    $field
                )
            );

        }

        $wrapper->text(
            $container->display()
        );
        echo '<div class="bf-section-container bf-taxonomies bf-clearfix">';
        echo $wrapper;
        echo '</div>';
    } // callback
}