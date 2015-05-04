<?php

class BF_Admin_Panel_Front_End_Generator extends BF_Admin_Fields{

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
     * @internal param $ (array)  $options Panel All Options
     * @internal param $ (string) $id        Panel ID
     * @internal param $ (array)  $values    Panel Saved Values
     *
     * @since 1.0
     * @access public
     * @return \BF_Admin_Panel_Front_End_Generator
     */
	public function __construct( array &$options, &$id, &$values = array() ){

        $default = array(
            'templates_dir' => BF_PATH . 'admin-panel/templates/'
        );
		// Parent Constructor
		parent::__construct( $default );

		$this->items  = $options;
		$this->id	  = $id;
		$this->values = $values;
	}


	/**
	 * Return The HTML Output of Tabs
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_tabs(){

		$fields = $this->items['fields'];

		// Generate Tabs Array
		$tabs_array		 = array();
		$prev_tab_key	 = 0;
		$menu_items      = array();

		foreach ( (array) $fields as $field )
			if ( $field['type'] == 'tab' || $field['type'] == 'subtab' )
				$tabs_array[] = $field;

		foreach ( $tabs_array as $k => $v ) {
			$token = $v['id'];
			// Capture the token.
			$v['token'] = $token;
			if ( $v['type'] == 'tab' ) {
				$menu_items[$token] = $v;
				$prev_tab_key 		= $token;
			}
			if ( $v['type'] == 'subtab' ) {
				$menu_items[$prev_tab_key]['children'][] = $v;
			}
		}


		$output   = '';
		$output  .= '<ul>';
		$tabs    = $menu_items;

		foreach ( $tabs as $tab_id => $tab ) {
			$hasChildren = isset( $tab['children'] ) && count( $tab['children'] ) > 0;
			$class	 = $hasChildren ? 'has-children' : '';

            if( isset( $tab['margin-top'] ) ){
                $class .= ' margin-top-' . $tab['margin-top'];
            }

            if( isset( $tab['margin-bottom'] ) ){
                $class .= ' margin-bottom-' . $tab['margin-bottom'];
            }

			$output .= '<li class="'.$class.'" data-go="'.$tab_id.'">';
			$output .= '<a href="#" class="bf-tab-item-a" data-go="'.$tab['id'].'">';



            // todo add support "Better Social Font Icon"
            if( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ){

                if( substr( $tab['icon'], 0, 3 ) == 'fa-' ){

                    $output .= '<div class="fa '. $tab['icon'] .'"></div>';

                }else{

                    $output .= '<div class="dashicons dashicons-'. $tab['icon'] .'"></div>';

                }

            }

            $output .= $tab['name'].'</a>';

			if ( $hasChildren ) {

				$output .= '<ul class="sub-nav">';

				foreach ( $tab['children'] as $child ) {
					$output .= '<li>';
					$output .= '<a href="#" class="bf-tab-subitem-a" data-go="'.$child['id'].'">'.$child['name'].'</a>';
					$output .= '</li>';
				}

				$output .= '</ul>';

			}

			$output .= '</li>';
		}
		$output .= '</ul>';

		return $output;

	}

    /**
     * Display HTML output of panel array
     *
     * Display full html of panel array which is defined in object parameter
     *
     * @since 1.0
     * @access public
     * @param bool $repeater
     * @return string
     */
	public function get_fields( $repeater = false ){

		$is_repeater = is_array( $repeater );
		$fields	 = $is_repeater ? $repeater['options'] : $this->items['fields'];
		$output	 = '';
		$counter = 0;
		$has_tab = false;
        $current_style = get_option( $this->id . '_current_style' );
        $std_id = Better_Framework::options()->get_std_field_id( $this->id );

		foreach( $fields as $field ){

            if( isset( $field['style'] ) && ! in_array( $current_style, $field['style'] ) )  continue;

            if( $field['type'] != 'repeater' )
				$field['input_name'] = $this->input_name( $field );

            // If value have been saved before
            if( isset( $field['id'] ) && isset( $this->values[ $field['id'] ] ) ){
                $field['value'] = $this->values[ $field['id'] ];
            }
            // Default value for current style
            elseif( isset( $field[$std_id] ) ){
                $field['value'] = $field[$std_id];
            }
            // Default value for default style!
            elseif( isset( $field['std'] ) ){
                $field['value'] = $field['std'];
            }

			if( $field['type'] == 'tab' || $field['type'] == 'subtab' ){
				$is_subtab = $field['type'] == 'subtab';
				if( $counter != 0 )
					$output .= '</div>';
				if( $is_subtab )
					$output .= "\n\n<!-- Section -->\n<div class='group subtab-group' id='bf-group-{$field['id']}'>\n";
				else
					$output .= "\n\n<!-- Section -->\n<div class='group' id='bf-group-{$field['id']}'>\n";
				$has_tab = true;
				continue;
			}

			if( !in_array( $field['type'], $this->supported_fields ) )
				continue;

            // for image checkbox sortable option
            if( isset($field['is_sortable']) && ($field['is_sortable']=='1') )
                $field['section_class'] .=' is-sortable';

			$output .= $this->section(
				call_user_func(
					array( $this, $field['type'] ),
					$field
				),
				$field
			);
			$counter++;

		} // foreach

		if( $has_tab )
			$output .= '</div>';
			
		return $output;	
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
        $panel_id  = $this->id;

        // Capture output
        ob_start();
        require $file;

        $data = ob_get_clean();

        return $data;
    }


}