<?php

/**
 * Panels Options Handler
 */
class BF_Options{

    /**
     * Contains options only in key => value that are saved in db before
     *
     * @var array
     */
    public  $cache   = array();


    /**
     * Contains all options with base config
     *
     * @var array
     */
    public $options = array();


    /**
     * Contains theme panel id
     *
     * @var bool
     */
    private $theme_panel_id = false;


    /**
     * Loads all options and save them to db if needed
     */
    function __construct(){

        $options = apply_filters( 'better-framework/panel/options', array() );

        foreach( $options as $id => $value ){

            // If panel has not valid ID, Continue the loop!
            if( preg_match( '/(\d+)|(^[^_a-zA-Z])(^\d)/', $id ) )
                continue;

            if( ! isset( $value['config'] ) || ! isset( $value['config']['name'] ) || ! isset( $value['fields'] ) || ! is_array( $value['fields'] ) )
                continue;

            $this->options[$id] = $value;

            // save options value to database if is not saved before
            if( ( $saved_value = get_option( $id ) ) == false ){

                // adds default style option if needed
                if( isset( $value['fields']['style'] ) ){
                    if( get_option( $id . '_current_style' ) == false ){
                        update_option( $id . '_current_style', 'default' );
                    }
                }

                // save to db
                $this->save_panel_options( $id );

                // refresh $saved_value because that will be added to cache
                $saved_value = get_option( $id );
            }

            // Adds saved value to cache
            $this->cache[$id] = $saved_value;

        }

    }


    /**
     * Saves panel options to database
     *
     * @param $id
     * @return bool
     */
    public function save_panel_options( $id ){

        $data 	= array();

        $std_id = $this->get_std_field_id( $id );

        $current_style = get_option( $id . '_current_style' );

        foreach( $this->options[$id]['fields'] as $field ) {

            // Not save if field have style filter
            if( isset( $field['style'] ) && ! in_array( $current_style, $field['style'] ) )  continue;

            // Field is not valid or haven't std value
            if ( ! isset( $field['id'] ) || ! isset( $field['type'] ) )
                continue;

            if( isset( $field[$std_id] ) ){
                $data[ $field['id'] ] = $field[$std_id];
            }
            elseif( isset( $field['std'] ) ){
                $data[ $field['id'] ] = $field['std'];
            }

        }

        delete_transient( $id . 'panel_css' );

        return update_option( $id, $data ) ;
    }


    /**
     * Get an option from the database (cached) or the default value provided
     * by the options setup.
     *
     * @param string $key
     * @param string $panel_key
     * @return mixed|null
     */
    public function get( $key, $panel_key = '' ){

        if( empty( $panel_key ) ){
            $panel_key = $this->get_theme_panel_id();
        }

        if( isset( $this->cache[$panel_key][$key] ) ){
                return $this->cache[$panel_key][$key];
        }

        $std_id = $this->get_std_field_id( $panel_key );

        foreach( $this->options[$panel_key]['fields'] as $option ){

            if( ! isset( $option['id'] ) || $option['id'] != $key ) continue;

            if( isset( $option[$std_id] ) ){
                return $option[$std_id];
            }
            elseif( isset( $option['std'] ) ){
                return $option['std'];
            }
            else{
                return null;
            }

        }

        return null;
    }


    /**
     * Remove all cache options
     */
    public function clear(){

        $this->cache = array();

        return $this;

    }


    /**
     * Updates local cache
     * Note DOES NOT saves to DB. Use update() to save.
     *
     * @param string|array $key
     * @param mixed $value  a value of null will unset the option
     * @return BF_Options
     */
    public function set( $key, $value = null ){

        // array? merge it!
        if( is_array( $key ) ){
            $this->cache = array_merge( $this->cache, $key );
            return $this;
        }

        if( $value === null ){
            unset( $this->cache[$key] );
        }
        else{
            $this->cache[$key] = $value;
        }

        return $this;
    }


    /**
     * Return default value field id
     *
     * @param $panel_id
     * @return string
     */
    public function get_std_field_id( $panel_id = false ){

        // if panel id is not defined then uses theme panel id
        if( $panel_id == false ){

            $panel_id = $this->get_theme_panel_id();

            if( $panel_id == false )
                return 'std';

        }

        if( isset( $this->options[$panel_id]['fields']['style'] ) ){

            $current_style = get_option( $panel_id . '_current_style' );

            if( $current_style == 'default' )
                return 'std';
            else
                return 'std-' . $current_style;

        }

        return 'std';

    }


    /**
     * Used for finding theme panel id
     *
     * @return bool|int|string
     */
    public function get_theme_panel_id(){

        if( $this->theme_panel_id != false )
            return $this->theme_panel_id;

        foreach( $this->options as $p_id => $panel_value ){

            if( isset( $panel_value['theme-panel'] ) ){

                $this->theme_panel_id = $p_id;

            }

        }

        return $this->theme_panel_id;

    }

}