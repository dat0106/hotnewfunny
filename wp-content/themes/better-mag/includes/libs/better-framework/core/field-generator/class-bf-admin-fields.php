<?php

abstract class BF_Admin_Fields{

    /**
     * Holds All Field Generator Options
     *
     * @since 1.0
     * @access private
     * @var array
     */
    protected  $options = array();


    /**
     * Holds All Supported Fields
     *
     * @since 1.0
     * @access private
     * @var array
     */
    public $supported_fields = array(
        'text',
        'textarea',
        'wp_editor',
        'code',
        'color',
        'date',
        'slider',
        'radio',
        'checkbox',
        'switchery',
        'repeater',
        'select',
        'ajax_select',
        'ajax_action',
        'sorter',
        'sorter_checkbox',
        'heading',
        'media',
        'background_image',
        'media_image',
        'image_upload',
        'image_checkbox',
        'image_radio',
        'image_select',
        'icon_select',
        'typography',
        'border',
        'export',
        'import',
        'info',
    );


    /**
     * PHP Constructor Function
     *
     * defining class options with constructor function
     *
     * @param array $options
     * @internal param $ (array) $options fields options array
     *
     * @since 1.0
     * @access public
     * @return \BF_Admin_Fields
     */
    public function __construct( $options = array() ){

        require_once BF_PATH . 'core/field-generator/class-bf-ajax-select-callbacks.php';

        $default_options = array(
            'fields_dir'	=>	 dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'fields' . DIRECTORY_SEPARATOR,
            'templates_dir'	=>	 dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
            'section-file' 	=> 	 dirname( __FILE__ ) . '/templates/default-fileld-template.php'
        );
        $this->options = array_merge( $default_options, $options );
    }


    /**
     * Setting object settings
     *
     * This class is for setting options
     *
     * @param (string)			   $option_name  	Name of option
     * @param (array|sting|bool)   $option_value 	Value of option
     *
     * @since 1.0
     * @access public
     * @return object
     */
    public function set( $option_name, $option_value ){
        $this->options[ $option_name ] = $option_value;
        return $this;
    }


    /**
     * Check if the panel has specific field
     *
     * @param (string) $type Field Type
     *
     * @since 1.0
     * @access public
     * @return bool
     */
    public function has_field( $field ){
        $has = false;
        foreach( $this->items as $item )
            if( @$item['type'] == $field )
                return true;

        return (bool) $has;
    }


    /**
     * Wrap the input in a section
     *
     * This class is for setting options
     *
     * @param (string)	$input   The string value of input (<input />))
     * @param (array)   $option	 Field options (like name, id etc)
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function section( $input, $options ){

        $template_file = $this->options['templates_dir'] . $options['type'] . '.php';
        ob_start();

        if( ! file_exists( $template_file ) )
            require $this->options['templates_dir'] . 'default.php';
        else
            require $template_file;

        return  ob_get_clean();

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

            case( 'image_checkbox' ):
                return "{$id}[%s]";
                break;

            default:
                return $id;
                break;

        }

        return $id;
    }


    /**
     * Get classes - @Vahid WTF!!!
     *
     * get element classes array
     *
     * @param (type) about this param
     *
     * @since 1.0
     * @access public
     * @return array
     */
    public function get_classes( &$options ){

        $is_repeater = isset( $options['repeater_item'] ) && $options['repeater_item'] === true;
        $classes = array();

        $classes['section'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/section', 'bf-section' );
        $classes['section'] .= empty( $options['section_class'] ) ? '' : ' ' . $options['section_class'];

        $classes['repeater-section'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/section/repeater', 'bf-repeater-section-option' );
        $classes['nonrepeater-section']		 				 =  apply_filters( 'better-framework/field-generator/class/section/nonrepeater', 'bf-nonrepeater-section' );
        $classes['section-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/section/by/type', 'bf-section-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-section-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/section/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-section', $options['type'] );
        $classes['repeater-section-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/section/repeater/by/type', 'bf-repeater-' . $options['type'] . '-section', $options['type'] );

        $classes['heading'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/heading', 'bf-heading' );
        $classes['repeater-heading'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater', 'bf-repeater-heading-option' );
        $classes['nonrepeater-heading']		 				 =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater', 'bf-nonrepeater-heading' );
        $classes['heading-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/heading/by/type', 'bf-heading-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-heading-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-heading', $options['type'] );
        $classes['repeater-heading-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater/by/type', 'bf-repeater-' . $options['type'] . '-heading', $options['type'] );

        $classes['controls'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/controls', 'bf-controls' );
        $classes['repeater-controls'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater', 'bf-repeater-controls-option' );
        $classes['nonrepeater-controls']		 			 =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater', 'bf-nonrepeater-controls' );
        $classes['controls-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/heading/by/type', 'bf-controls-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-controls-class-by-filed-type'] =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-controls', $options['type'] );
        $classes['repeater-controls-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater/by/type', 'bf-repeater-' . $options['type'] . '-controls', $options['type'] );

        $classes['explain'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/explain', 'bf-explain' );
        $classes['repeater-explain'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/explain/repeater', 'bf-repeater-explain-option' );
        $classes['nonrepeater-explain']		 				 =  apply_filters( 'better-framework/field-generator/class/explain/nonrepeater', 'bf-nonrepeater-explain' );
        $classes['explain-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/explain/by/type', 'bf-explain-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-explain-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/explain/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-explain', $options['type'] );
        $classes['repeater-explain-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/explain/repeater/by/type', 'bf-repeater-' . $options['type'] . '-explain', $options['type'] );

         return $classes;

    }


    /**
     * PHP __call Magic Function
     *
     * @param $name
     * @param $arguments
     * @throws Exception
     * @internal param $ (string) $name      name of requested method
     * @internal param $ (array)  $arguments arguments of requested method
     *
     * @since 1.0
     * @access public
     * @return mixed
     */
    public function __call( $name, $arguments ){

        $file = $this->options['fields_dir'] . $name . '.php';

        // Check if requested field (method) does exist!
        if( ! file_exists( $file ) )
            throw new Exception( $name . ' does not exist!' );

        $options = $arguments[0];

        // Capture output
        ob_start();
        require $file;

        $data = ob_get_clean();

        return $data;
    }

}