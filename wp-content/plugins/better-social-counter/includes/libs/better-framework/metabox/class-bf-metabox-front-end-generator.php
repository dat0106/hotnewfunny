<?php

/**
 * Metabox Fields Generator
 *
 * TODO refactor and remove tabs ability
 */
class BF_Metabox_Front_End_Generator extends BF_Admin_Fields{

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
     * @param array $options    Panel All Options
     * @param $id               Panel ID
     * @param array $values     Panel Saved Values
     *
     * @since 1.0
     * @access public
     */
    public function __construct( array &$options, &$id, &$values = array() ){
        // Parent Constructor
        parent::__construct( array(
            'templates_dir' => BF_PATH . 'metabox/templates/'
        ));

        $this->items  = $options;
        $this->id	  = $id;
        $this->values = $values;
    }


    public function has_tab(){

        foreach( $this->items['fields'] as $field )
            if( $field['type'] == 'tab' )
                return true;

        return false;

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
            $output .= '<li class="'.$class.'" data-go="'.$tab_id.'">';
            $output .= '<a href="#" class="bf-tab-item-a" data-go="'.$tab['id'].'">'.$tab['name'].'</a>';
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

    public function input_name( &$options ){
        $id   = @$options['id'];
        $type = @$options['type'];

        switch( $type ){

            case( 'repeater' ):
                return "bf-metabox-option[%s][%s][%d][%s]";
                break;

            default:
                return "bf-metabox-option[{$this->id}][{$id}]";
                break;

        }

    }


    public function callback(){

        $items_has_tab = $this->has_tab();
        $has_tab 	   = false;
        $wrapper   	   = Better_Framework::html()->add( 'div' )->class( 'bf-metabox-wrap bf-clearfix' )->data( 'id', $this->id );

        // Add Class For Post Format Filter
        if(isset($this->items['config']['post_format'])){
            $wrapper->data('bf_pf_filter', implode(',',$this->items['config']['post_format']));
        }

        $container 	   = Better_Framework::html()->add( 'div' )->class( 'bf-metabox-container' );
        $tab_counter   = 0;

        if( $items_has_tab ) {
            $container->class( 'bf-with-tabs' );
            $tabs_container = Better_Framework::html()->add( 'div' )->class( 'bf-metabox-tabs' );
            $tabs_container->text( $this->get_tabs() );
            $wrapper->text( $tabs_container->display() );
        }

        if( isset( $this->items['panel-id'] ) ){
            $std_id = Better_Framework::options()->get_std_field_id( $this->items['panel-id'] );
        }else{
            $std_id = 'std';
        }

        foreach( $this->items['fields'] as $field ){

            $field['input_name'] = $this->input_name( $field );

            $field['value'] = isset( $this->values[ @$field['id'] ] ) ? $this->values[ $field['id'] ] : false;

            if( $field['value'] == false && isset( $field[$std_id] ) ){
                $field['value'] = $field[$std_id];
            }

            if( $field['type'] == 'repeater' ){
                $field['clone-name-format'] = 'bf-metabox-option[$1][$2][$3][$4]';
                $field['metabox-id'] = $this->id;
                $field['metabox-field'] = true;
            }

            if( $field['type'] == 'tab' || $field['type'] == 'subtab' ){
                $is_subtab = $field['type'] == 'subtab';
                if( $tab_counter != 0 )
                    $container->text( '</div>' );
                if( $is_subtab )
                    $container->text( "\n\n<!-- Section -->\n<div class='group subtab-group' id='bf-metabox-{$this->id}-{$field["id"]}'>\n" );
                else
                    $container->text( "\n\n<!-- Section -->\n<div class='group' id='bf-metabox-{$this->id}-{$field["id"]}'>\n" );
                $has_tab = true;
                $tab_counter++;
                continue;
            }

            if( !in_array( $field['type'], $this->supported_fields ) )
                continue;

            // Filter Each Field For Post Formats!
            if( isset( $field['post_format'] )){

                if( is_array( $field['post_format'] ) ){
                    $field_post_formats = implode( ',', $field['post_format'] );
                }else{
                    $field_post_formats = $field['post_format'];
                }
                $container->text( "<div class='bf-field-post-format-filter' data-bf_pf_filter='{$field_post_formats}'>");
            }

            $container->text(
                $this->section(
                    call_user_func(
                        array( $this, $field['type'] ),
                        $field
                    ),
                    $field
                )
            );

            // End Post Format Filter Wrapper
            if( isset( $field['post_format'] ) ){

                $container->text( "</div>");
            }
        }

        $wrapper->text( $container->display() );
        echo $wrapper;
    } // callback
}