<?php

/**
 * Manage all shortcode element registration
 */
class BF_Shortcodes_Manager {


    /**
     * Contain All shortcodes
     *
     * @var array
     */
    var $shortcodes = array();


    /**
     * Instances of all BetterFramework active shortcode
     *
     * @var array
     */
    private static $shortcode_instances = array();


    function __construct(){

        // Base class for all shortcodes
        require_once BF_PATH . 'shortcode/class-bf-shortcode.php';

        // Filter active shortcodes
        $this->load_shortcodes();

        // Initialize active shortcodes
        $this->init_shortcodes();

    }


    /**
     * Get active short codes from bf_active_shortcodes filter
     */
    function load_shortcodes(){
        $this->shortcodes = (array) apply_filters( 'better-framework/shortcodes' , array() );
    }


    /**
     * Initialize active shortcodes
     */
    function init_shortcodes(){

        foreach( $this->shortcodes as $key => $shortcode ){

            self::factory( $key, $shortcode );

        }

    }


    /**
     * Factory For All BF Active Shortcodes
     *
     * @param string $key
     * @param $options
     * @return null|BF_Shortcode
     */
    static function factory( $key = '' , $options = array() ){

        if( $key == '' ) return null;

        if( isset( self::$shortcode_instances[$key] ) ){
            return self::$shortcode_instances[$key];
        }else{

            //
            // Short Code That Haves Specific Handler Out Side Of BF
            //
            if( isset( $options['shortcode_class'] ) ){
                $class = $options['shortcode_class'];
                self::$shortcode_instances[$key] = new $class( $key , $options );
                return self::$shortcode_instances[$key];
            }

            //
            // Active Shortcodes In Inner BF
            //
            $class = BF_Helper::get_file_to_class_name( $key , 'BF_' , '_Shortcode' );

            if( ! class_exists( $class ) ){
                if( file_exists( BF_PATH .'shortcode/shortcodes/class-bf-' . $key . '-shortcode.php' )){
                    require_once BF_PATH .'shortcode/shortcodes/class-bf-' . $key . '-shortcode.php';
                }
            }

            self::$shortcode_instances[$key] = new $class( $key , $options );
            return self::$shortcode_instances[$key];
        }
    }
}
