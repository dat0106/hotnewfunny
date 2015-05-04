<?php

/**
 * Used for adding fields for all WordPress widgets
 */
class BF_Widgets_General_Fields {

    /**
     * Contain active general fields
     *
     * @var array
     */
    var $fields = array();


    /**
     * Contain current fields options
     *
     * @var array
     */
    private $options = array();


    function __construct(){
        $this->fields = apply_filters( 'better-framework/widgets/options/general', $this->fields );

        // Prepare fields for generator
        $this->load_options();

        // Add input fields(priority 10, 3 parameters)
        add_action( 'in_widget_form', array( $this , 'in_widget_form' ), 5, 3 );

        // Callback function for options update (priority 5, 3 parameters)
        add_filter('widget_update_callback', array( $this , 'in_widget_form_update') ,99,3);
    }


    /**
     * Check for when a field is general field
     *
     * @param $field
     * @return bool
     */
    public static function is_general_field( $field ){
        return in_array( $field , array( 'heading_color' , 'heading_bg' ) );
    }


    /**
     * Init a general field generator options
     *
     * @param $field
     */
    private function register_option( $field ){
        switch( $field ){
            case 'heading_color':
                $this->options[] = array(
                    'name' => __('Widget Title Color','better-studio'),
                    'attr_id' => 'heading_color',
                    'type' => 'color',
                    'std'   => apply_filters( 'better-framework/widgets/options/general/heading_color/default' , '' ),
                );
                break;

            case 'heading_bg':
                $this->options[] = array(
                    'name' => __( 'Widget Title Background Color', 'better-studio' ),
                    'attr_id' => 'heading_bg',
                    'type' => 'color',
                    'std'   => apply_filters( 'better-framework/widgets/options/general/heading_bg/default' , '' ),
                );
                break;


        }

    }

    /**
     * Save active fields values
     *
     * @param $instance
     * @param $new_instance
     * @param $old_instance
     * @return mixed
     */
    function in_widget_form_update($instance, $new_instance, $old_instance){

        // Remove default fields
        foreach( $this->options as $option ){
            $def[$option['attr_id']] = $option['std'];
        }
        if( isset( $new_instance['heading_color'] ) ){
            if( $new_instance['heading_color'] != $def['heading_color'] )
                $instance['heading_color'] = $new_instance['heading_color'];
            else
                unset( $new_instance['heading_color'] );
        }
        if( isset( $new_instance['heading_bg'] ) ){
            if( $new_instance['heading_bg'] != $def['heading_bg'] )
                $instance['heading_bg'] = $new_instance['heading_bg'];
            else
                unset( $new_instance['heading_bg'] );
        }

        return $instance;
    }


    /**
     * load options for active fields
     */
    function load_options(){

        foreach( (array) $this->fields as $key => $value ){

            if( self::is_general_field($value) ){
                $this->register_option( $value );
            }

        }

    }


    /**
     * @param $widget WP_Widget
     */
    function prepare_fields( $widget ){
        for( $i=0 ; $i < count( $this->options ) ; $i++ ){
            $this->options[$i]['input_name'] = $widget->get_field_name( $this->options[$i]['attr_id'] );
            $this->options[$i]['id'] = $widget->get_field_id( $this->options[$i]['attr_id']);
        }
    }


    /**
     * Add input fields to widget form
     *
     * @param $t
     * @param $return
     * @param $instance
     */
    function in_widget_form( $t, $return, $instance ){

        Better_Framework::factory( 'widgets-field-generator' , false , true );

        $this->prepare_fields( $t );

        $options = array(
            'fields'    => $this->options
        );

        $generator = new BF_Widgets_Field_Generator( $options , $instance );

        echo $generator->get_fields();
    }
}